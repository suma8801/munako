<?php
// 
// src/Controller/ApisController.php
// API関連を集めたコントローラ
// 最初はAPI一つ
namespace App\Controller;

use App\Controller\AppController;
use App\Service\TenmeiService;
use Cake\Controller\Component\RequestHandlerComponent;

class ApisController extends AppController
{
    // 初期化
    public function initialize(): void
    {
        parent::initialize();

        // これらのアクションは未認証でもアクセス可能
        $this->Authentication->allowUnauthenticated(['calcByBirthday']);
    }

    // 誕生日から、天命、才能、弱点をJSONで返す
    // @param  $birthday String 19700228 or 19700228_h
    // @return $array
    public function calcByBirthday( $birthday ): void
    {
        // レイアウトを使用しない
        $this->viewBuilder()->disableAutoLayout();

        // UserServiceのインスタンスを生成し、ロジックを実行
        $tenmeiService = new TenmeiService();

        // 戻り値は配列の形で受け取る
        $result = $tenmeiService->calcTenmei( $birthday );

        $retval = [];
        $retval["result"] = $result ;

        // 結果は JSON形式で返す
        // {"result":["王様","兵士","魔法使い"]}
        // または、ハイブリッドの時
        // {"result":[["王様","兵士","魔法使い"],["月","女帝","力"]]}
        $this->viewBuilder()->setClassName('Json');
        $this->viewBuilder()->setOption('serialize', 'result');
        $this->viewBuilder()->setOption('jsonOptions', JSON_UNESCAPED_UNICODE);
    
        $this->set('result', $retval);

    }
}
?>