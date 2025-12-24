<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Service\MemberSearchService;
use App\Service\DashboardStatisticsService;
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

    // スタッフ・管理者がログインした時に表示されるダッシュボード
    public function dashboard()
    {
        // 権限チェック: スタッフ(2)または管理者(3)のみ
        $identity = $this->request->getAttribute('authentication')?->getIdentity();
        if ($identity) {
            $currentUser = $identity->getOriginalData();
            $currentRoleId = $currentUser->role_id ?? null;
            if (!in_array((int)$currentRoleId, [2, 3], true)) {
                $this->Flash->error('このページにアクセスする権限がありません。');
                return $this->redirect(['action' => 'regacy']);
            }
        }

        // サービスクラスをインスタンス化
        $dashboardStatisticsService = new DashboardStatisticsService();
        $statistics = $dashboardStatisticsService->getDashboardStatistics();

        // 開催年ごとの参加者数データを展開
        $attendanceByYearData = $statistics['attendanceByYear'];

        $this->set([
            'totalMembers' => $statistics['totalMembers'],
            'deceasedCount' => $statistics['deceasedCount'],
            'aliveCount' => $statistics['aliveCount'],
            'years' => $attendanceByYearData['years'],
            'maleCounts' => $attendanceByYearData['maleCounts'],
            'femaleCounts' => $attendanceByYearData['femaleCounts'],
            'totalCounts' => $attendanceByYearData['totalCounts'],
            'attendanceByYear' => $attendanceByYearData['attendanceByYear'],
            'membersByClass' => $statistics['membersByClass'],
            'deceasedByClass' => $statistics['deceasedByClass'],
            'attendance2023ByClass' => $statistics['attendance2023ByClass'],
        ]);
    }

}
