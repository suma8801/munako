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

    /**
     * クラス別出欠状況管理
     * スタッフ・管理者のみアクセス可能
     */
    public function classAttendance(?int $class = null)
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
        } else {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // クラスが指定されていない場合はエラー
        if ($class === null) {
            $this->Flash->error('クラスが指定されていません。');
            return $this->redirect(['action' => 'dashboard']);
        }

        // 次に開催される同窓会の年を使用
        $year = NEXT_YEAR;

        $membersTable = $this->fetchTable('Members');
        $reunionAttendsTable = $this->fetchTable('ReunionAttends');
        $attendStatusesTable = $this->fetchTable('AttendStatuses');

        // 指定クラスのメンバー一覧を取得
        $members = $membersTable->find()
            ->where(['class' => $class])
            ->orderBy(['no' => 'ASC'])
            ->toArray();

        // 出欠ステータス一覧を取得
        $attendStatuses = $attendStatusesTable->find()
            ->orderBy(['id' => 'ASC'])
            ->toArray();

        // 各メンバーの出欠状況を取得
        $memberIds = array_column($members, 'id');
        $attendances = [];
        if (!empty($memberIds)) {
            $attendanceRecords = $reunionAttendsTable->find()
                ->where([
                    'member_id IN' => $memberIds,
                    'year' => $year
                ])
                ->contain(['AttendStatuses'])
                ->toArray();

            // member_idをキーとした配列に変換
            foreach ($attendanceRecords as $record) {
                $attendances[$record->member_id] = $record;
            }
        }

        $this->set(compact('class', 'year', 'members', 'attendStatuses', 'attendances'));
    }

    /**
     * 個別メンバーの出欠状況編集ページ
     * スタッフ・管理者のみアクセス可能
     */
    public function editAttendance(?int $class = null, ?int $memberId = null)
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
        } else {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // クラスとメンバーIDが指定されていない場合はエラー
        if ($class === null || $memberId === null) {
            $this->Flash->error('パラメータが不正です。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $year = NEXT_YEAR;

        $membersTable = $this->fetchTable('Members');
        $reunionAttendsTable = $this->fetchTable('ReunionAttends');
        $attendStatusesTable = $this->fetchTable('AttendStatuses');

        // メンバー情報を取得
        $member = $membersTable->get($memberId);
        if (!$member || $member->class != $class) {
            $this->Flash->error('メンバーが見つかりません。');
            return $this->redirect(['action' => 'classAttendance', $class]);
        }

        // 出欠ステータス一覧を取得
        $attendStatuses = $attendStatusesTable->find()
            ->orderBy(['id' => 'ASC'])
            ->toArray();

        // 現在の出欠状況を取得
        $attendance = $reunionAttendsTable->find()
            ->where([
                'member_id' => $memberId,
                'year' => $year
            ])
            ->contain(['AttendStatuses'])
            ->first();

        $this->set(compact('class', 'year', 'member', 'attendStatuses', 'attendance'));
    }

    /**
     * 出欠状況を更新
     * スタッフ・管理者のみアクセス可能
     */
    public function updateAttendance()
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
        } else {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $this->request->allowMethod(['post', 'put', 'patch']);

        $data = $this->request->getData();
        $memberId = (int)($data['member_id'] ?? 0);
        $year = NEXT_YEAR; // 次に開催される同窓会の年を使用
        $class = (int)($data['class'] ?? 0);
        $attendStatusId = isset($data['attend_status_id']) ? (int)$data['attend_status_id'] : null;
        $note = $data['note'] ?? null;

        if ($memberId === 0 || $class === 0) {
            $this->Flash->error('不正なリクエストです。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $reunionAttendsTable = $this->fetchTable('ReunionAttends');

        // 既存のレコードを検索
        $existingRecord = $reunionAttendsTable->find()
            ->where([
                'member_id' => $memberId,
                'year' => $year
            ])
            ->first();

        if ($existingRecord) {
            // 既存レコードを更新
            if ($attendStatusId !== null) {
                $existingRecord->attend_status_id = $attendStatusId;
            }
            if ($note !== null) {
                $existingRecord->note = $note;
            }
            $reunionAttendsTable->save($existingRecord);
        } else {
            // 新規レコードを作成
            if ($attendStatusId === null) {
                $this->Flash->error('出欠ステータスが指定されていません。');
                return $this->redirect(['action' => 'classAttendance', $class]);
            }

            $newRecord = $reunionAttendsTable->newEntity([
                'member_id' => $memberId,
                'year' => $year,
                'attend_status_id' => $attendStatusId,
                'note' => $note
            ]);
            $reunionAttendsTable->save($newRecord);
        }

        $this->Flash->success('出欠状況を更新しました。');
        return $this->redirect(['action' => 'editAttendance', $class, $memberId]);
    }

}
