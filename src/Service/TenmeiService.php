<?php
// src/Service/TenmeiService.php
namespace App\Service;

use App\Model\Table\DestinyResultsTable;
use App\Model\Table\TalentResultsTable;
use App\Model\Table\WeaknessResultsTable;
use App\Logics\TenmeiLogic;
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;

// 天命関連のサービス
class TenmeiService
{
    // 各リザルトテーブル
    private $destinyTable;
    private $talentTable;
    private $weaknessTable;

    public function __construct()
    {
        $this->destinyTable  = TableRegistry::getTableLocator()->get('DestinyResults');
        $this->talentTable   = TableRegistry::getTableLocator()->get('TalentResults');
        $this->weaknessTable = TableRegistry::getTableLocator()->get('WeaknessResults');
    }

    /*
    * 結果を配列で返す
    * @param string $birthday 19700228 または _h がついている形式
    * @return 例）array['鳳凰','月','陰者']
    */
    public function calcTenmei(string $birthday ): array
    {
        // _h が付いているかどうかを判定
        $hybrid = str_ends_with($birthday, '_h');

        if ($hybrid) {
            // _h が付いている場合、'_h' を取り除く
            $birthday = str_replace('_h', '', $birthday);
        }

        // 処理結果を格納する配列
        $result = [];
        $tenmeiLogic = new TenmeiLogic();

        // 生年月日から年、月、日を抽出
        // 最初の8文字が日付部分と仮定
        $year  = (int)substr($birthday, 0, 4);
        $month = (int)substr($birthday, 4, 2);
        $day   = (int)substr($birthday, 6, 2);

        // 基本の計算
        $result[] = $this->trans_card_title( 
            $tenmeiLogic->calculateFortuneTelling($year, $month, $day) );

        // $hybrid が true の場合、一日前の日付で再計算
        if ($hybrid) {
            // 現在の日付からDateTimeオブジェクトを作成
            $date = new \DateTime("{$year}-{$month}-{$day}");
            
            // 1日前の日付を計算
            $date->modify('-1 day');
            
            // 新しい年、月、日を取得
            $prevYear  = (int)$date->format('Y');
            $prevMonth = (int)$date->format('m');
            $prevDay   = (int)$date->format('d');

            // 1日前の運勢を計算して配列に追加
            $result[] = $this->trans_card_title( 
                $tenmeiLogic->calculateFortuneTelling( $prevYear, $prevMonth, $prevDay) 
            );
        }
        return $result;
    }

    /**
     * @param $param 連想配列の形からカードのタイトルに変換
     * @return 例）array['鳳凰','月','陰者']
     */
    private function trans_card_title( $param ): array
    {
        $str_arr = [];

        try {
            // 才能、弱点、天命の順番でデータを準備する
            $str_arr[] = $this->talentTable->get($param['talent'])->card_title;
            // 弱点だけ２つある場合がある
            if( $param['weakness'] == 22 ){

                // 特別な処理
                $addstr  = $this->weaknessTable->get($param['weakness'])->card_title;
                $addstr .= "|" . $this->weaknessTable->get(19)->card_title;
                $str_arr[] = $addstr;

            } else {

                $str_arr[] = $this->weaknessTable->get($param['weakness'])->card_title;
            }
            $str_arr[] = $this->destinyTable->get($param['destiny'])->card_title;
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            // レコードが見つからない場合の処理
            // 例えば、ログを記録したり、空の配列を返したりする
            return [];
        }

        return $str_arr;
    }


    /**
     * @param $request HTTPリクエスト
     * @return 例）array[
     *    'talent'    => タレントのエンティティ,
     *    'weakness'  => 弱点のエンティティ,
     *    'destiny'   => 天命 * のエンティティ,
     *    'weakness2' => 弱点2のエンティティ(特別な場合)
     * ]
     */
    public function get_tenmei_result( $request ): array
    {
        // postで渡されたデータ取得
        $year  = (int)$request->getData( 'year' );
        $month = (int)$request->getData( 'month' );
        $day   = (int)$request->getData( 'day' );

        // 処理結果を格納する配列
        $tenmeiLogic = new TenmeiLogic();

        // 天命の計算
        // 返ってくるのは、連想配列
        $result_calc =  $tenmeiLogic->calculateFortuneTelling($year, $month, $day) ;

        $result['talent']   = $this->talentTable->get(   $result_calc['talent']   );
        $result['weakness'] = $this->weaknessTable->get( $result_calc['weakness'] );
        $result['destiny']  = $this->destinyTable->get(  $result_calc['destiny']  );

        // 弱点 22 の場合は特別に ２つ目の弱点がある
        if( $result_calc['weakness'] === 22 ){
            // 太陽のデータを取得
            $result['weakness2'] = $this->weaknessTable->get( 19 );
        } else {
            // 通常はこちらはない
            $result['weakness2'] = null;
        }

        return $result;
    }


}
?>