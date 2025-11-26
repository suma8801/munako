<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Service\MemberSearchService;
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
        $this->Authentication->allowUnauthenticated(['index']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->set('title', '宗高同窓会ホーム');
        $this->set('description', '宗高昭和56年卒業のホームページ');
        $this->set('keywords', '宗像 高校 同窓生');
        $this->set('author', 'suma8801@gmail.com');
        $this->set('robots', 'noindex, nofollow');
        $this->set('canonical', '宗高同窓会ホーム');
        $this->set('og:title', 'ホームページ');
    }

    public function index(){
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // ログインタイプを判定
            $loginType = $data['login_type'] ?? null;
            
            if ($loginType === 'general') {
                // 一般ログイン処理
                return $this->redirect(['controller' => 'Users', 'action' => 'login', '?' => ['type' => 'general']]);
            } elseif ($loginType === 'staff') {
                // スタッフログイン処理
                return $this->redirect(['controller' => 'Users', 'action' => 'login', '?' => ['type' => 'staff']]);
            }
        }
    }

    // 一般がログインした時に表示されるページ
    public function regacy()
    {
        // メソッドチェック
        $this->request->allowMethod(['get', 'post']);

        // サービスクラスをインスタンス化
        $memberSearchService = new MemberSearchService();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData("keyword");
            $results = $memberSearchService->searchMembers($data);
            $this->set(compact('results'));
        } else {
            $results = $memberSearchService->searchMembers('');
            $this->set(compact('results'));
        }
    }

}
