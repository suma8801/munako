<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Service\TenmeiService;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Controller\Component\RequestHandlerComponent;
/*
*/
/**
 * Homes Controller
 * ログインした後のページ類
 * 
 * regacy  -- 旧システムの最初のページ
 * regacy_result -- 旧システムの結果表示
 * welcome -- 新システムの最初に表示されるページ
 * 
 */
class HomesController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // 認証が必要ないアクションを設定（ミドルウェアレベルで処理）
        // この設定は不要です
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    // レガシーページ
    public function regacy()
    {
        // レイアウトのセット
        $this->set('title', '天命占い');
        $this->set('style', 'prostyle');

        // ハンバーガーメニューの表示判定
        $user = $this->Authentication->getIdentity();
        $showHamburger = $user && in_array($user->role_id, [2, 3]);
        $this->set('showHamburger', $showHamburger);

        // レイアウトは旧版
        $this->viewBuilder()->setLayout("regacy_layout");
    }

    // レガシーリザルト
    public function regacyResult()
    {
        // レイアウトのセット
        $this->set('title', '天命占い結果');
        $this->set('style', 'proresultstyles');

        // ハンバーガーメニューの表示判定
        $user = $this->Authentication->getIdentity();
        $showHamburger = $user && in_array($user->role_id, [2, 3]);
        $this->set('showHamburger', $showHamburger);

        // レイアウトは旧版
        $this->viewBuilder()->setLayout("regacy_layout");

        // ポストの処理
        if ($this->request->is('post')) {
            // UserServiceのインスタンスを生成し、ロジックを実行
            $tenmeiService = new TenmeiService();

            // それそれのテーブルのエンティティを取得
            $result_set = $tenmeiService->get_tenmei_result( $this->request );

        } else {
            // postでない場合は、リダイレクト
            return $this->redirect(['controller' => 'Homes', 'action' => 'regacy']);
        }
        $this->set( compact('result_set') );
    }

}
