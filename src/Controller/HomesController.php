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

        $membersTable = $this->fetchTable('Members');
        $reunionAttendsTable = $this->fetchTable('ReunionAttends');

        // 全体の人数
        $totalMembers = $membersTable->find()->count();

        // 亡くなった人の人数（gone = 1）
        $deceasedCount = $membersTable->find()
            ->where(['gone' => 1])
            ->count();

        // 生存者の人数
        $aliveCount = $membersTable->find()
            ->where(['OR' => [
                'gone IS' => null,
                'gone !=' => 1
            ]])
            ->count();

        // 開催年ごとの参加者数（重複を除いたユニークなmember_idの数）
        // まず開催年のリストを取得
        $yearList = $reunionAttendsTable->find()
            ->select(['year' => 'ReunionAttends.year'])
            ->distinct()
            ->order(['ReunionAttends.year' => 'ASC'])
            ->toArray();

        // 各年ごとに参加者数をカウント（重複を除いたユニークなmember_idの数）
        $attendanceByYear = [];
        $years = [];
        $counts = [];
        foreach ($yearList as $yearItem) {
            $year = $yearItem->year;
            // その年のユニークなmember_idのリストを取得してカウント
            $uniqueMembers = $reunionAttendsTable->find()
                ->select(['member_id'])
                ->where(['ReunionAttends.year' => $year])
                ->distinct()
                ->toArray();
            
            $uniqueCount = count($uniqueMembers);
            
            $years[] = $year;
            $counts[] = $uniqueCount;
            $attendanceByYear[] = (object)[
                'year' => $year,
                'count' => $uniqueCount
            ];
        }

        // クラス別の人数統計（追加の興味深いデータ）
        $membersByClass = $membersTable->find()
            ->select([
                'class' => 'Members.class',
                'count' => 'COUNT(Members.id)'
            ])
            ->group('Members.class')
            ->order(['Members.class' => 'ASC'])
            ->toArray();

        // クラスごとの物故者数
        $deceasedByClass = $membersTable->find()
            ->select([
                'class' => 'Members.class',
                'count' => 'COUNT(Members.id)'
            ])
            ->where(['gone' => 1])
            ->group('Members.class')
            ->order(['Members.class' => 'ASC'])
            ->toArray();

        // クラスごとの2023年の出席数
        $attendance2023ByClass = [];
        foreach ($membersByClass as $classStat) {
            $class = $classStat->class;
            // そのクラスのメンバーIDリストを取得
            $classMembers = $membersTable->find()
                ->select(['id'])
                ->where(['class' => $class])
                ->toArray();
            
            $classMemberIds = array_column($classMembers, 'id');
            
            if (!empty($classMemberIds)) {
                // そのクラスのメンバーで2023年に出席したユニークなメンバー数
                $attendedMembers = $reunionAttendsTable->find()
                    ->where([
                        'ReunionAttends.year' => 2023,
                        'ReunionAttends.member_id IN' => $classMemberIds
                    ])
                    ->select(['member_id'])
                    ->distinct()
                    ->toArray();
                
                $attendance2023ByClass[$class] = count($attendedMembers);
            } else {
                $attendance2023ByClass[$class] = 0;
            }
        }

        $this->set(compact(
            'totalMembers',
            'deceasedCount',
            'aliveCount',
            'years',
            'counts',
            'attendanceByYear',
            'membersByClass',
            'deceasedByClass',
            'attendance2023ByClass'
        ));
    }

}
