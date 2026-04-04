<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Service\MemberSearchService;
use Cake\Core\Configure;
use App\Service\DashboardStatisticsService;
use App\Service\AttendanceUpdateService;
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

    public function index()
    {
        // 一般ログインは /users/login-user 、スタッフログインは /users/login-staff へリンクで誘導
        $this->set('oauthLoginProviders', $this->buildOauthLoginProviders());
    }

    /**
     * ホームに表示する OAuth ボタン用（有効かつ最低限の設定が揃ったプロバイダーのみ）
     *
     * @return list<array{slug: string, buttonText: string}>
     */
    protected function buildOauthLoginProviders(): array
    {
        $oauth = Configure::read('OAuth') ?? [];
        $defs = [
            ['key' => 'Google', 'slug' => 'google', 'buttonText' => __('Googleでログイン')],
            ['key' => 'Apple', 'slug' => 'apple', 'buttonText' => __('Appleでログイン')],
            ['key' => 'X', 'slug' => 'x', 'buttonText' => __('Xでログイン')],
            ['key' => 'Line', 'slug' => 'line', 'buttonText' => __('LINEでログイン')],
        ];
        $out = [];
        foreach ($defs as $row) {
            $cfg = $oauth[$row['key']] ?? [];
            if (empty($cfg['enabled']) || !$this->isOauthProviderConfigured($row['key'], $cfg)) {
                continue;
            }
            $out[] = [
                'slug' => $row['slug'],
                'buttonText' => $row['buttonText'],
            ];
        }

        return $out;
    }

    /**
     * @param array<string, mixed> $cfg
     */
    protected function isOauthProviderConfigured(string $configKey, array $cfg): bool
    {
        $clientId = trim((string)($cfg['clientId'] ?? ''));
        $redirectUri = trim((string)($cfg['redirectUri'] ?? ''));
        if ($clientId === '' || $redirectUri === '') {
            return false;
        }

        return match ($configKey) {
            'Google', 'X', 'Line' => trim((string)($cfg['clientSecret'] ?? '')) !== '',
            'Apple' => $this->isAppleOauthConfigured($cfg),
            default => false,
        };
    }

    /**
     * @param array<string, mixed> $cfg
     */
    protected function isAppleOauthConfigured(array $cfg): bool
    {
        $teamId = trim((string)($cfg['teamId'] ?? ''));
        $keyFileId = trim((string)($cfg['keyFileId'] ?? ''));
        $keyFilePath = trim((string)($cfg['keyFilePath'] ?? ''));
        if ($teamId === '' || $keyFileId === '' || $keyFilePath === '') {
            return false;
        }

        return is_readable($keyFilePath);
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
        $currentRoleId = $this->getEffectiveRoleId();
        if ($currentRoleId === null) {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        if (!in_array($currentRoleId, [2, 3], true)) {
            $this->Flash->error('このページにアクセスする権限がありません。');
            return $this->redirect(['action' => 'regacy']);
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
            'attendanceNextYearByClass' => $statistics['attendanceNextYearByClass'],
            'nextYear' => NEXT_YEAR,
        ]);
    }

    /**
     * 指定年の参加者一覧（グラフの棒クリック時）
     * スタッフ・管理者のみアクセス可能
     */
    public function attendanceByYear(?int $year = null)
    {
        $currentRoleId = $this->getEffectiveRoleId();
        if ($currentRoleId === null) {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        if (!in_array($currentRoleId, [2, 3], true)) {
            $this->Flash->error('このページにアクセスする権限がありません。');
            return $this->redirect(['action' => 'regacy']);
        }

        if ($year === null) {
            $this->Flash->error('開催年が指定されていません。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $gender = $this->request->getQuery('gender');
        if ($gender !== null && $gender !== 'male' && $gender !== 'female') {
            $gender = null;
        }

        $dashboardStatisticsService = new DashboardStatisticsService();
        $records = $dashboardStatisticsService->getAttendeesByYear($year, $gender);

        $this->set(compact('year', 'records', 'gender'));
    }

    /**
     * 指定年の参加者一覧をCSVでダウンロード
     * スタッフ・管理者のみアクセス可能
     * @return \Cake\Http\Response|null
     */
    public function attendanceByYearCsv(?int $year = null)
    {
        $currentRoleId = $this->getEffectiveRoleId();
        if ($currentRoleId === null) {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        if (!in_array($currentRoleId, [2, 3], true)) {
            $this->Flash->error('このページにアクセスする権限がありません。');
            return $this->redirect(['action' => 'regacy']);
        }

        if ($year === null) {
            $this->Flash->error('開催年が指定されていません。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $gender = $this->request->getQuery('gender');
        if ($gender !== null && $gender !== 'male' && $gender !== 'female') {
            $gender = null;
        }

        $dashboardStatisticsService = new DashboardStatisticsService();
        $records = $dashboardStatisticsService->getAttendeesByYear($year, $gender);

        $csvRows = [];
        $csvRows[] = ['クラス', '番号', '名前', '性別', '出欠状況', 'メモ'];
        foreach ($records as $record) {
            $member = $record->member;
            $statusName = $record->attend_status ? $record->attend_status->name : '--';
            $sexLabel = $member->sex == 1 ? '男性' : '女性';
            $note = $record->note ?? '';
            $csvRows[] = [
                $member->class . '組',
                (string)$member->no,
                $member->name,
                $sexLabel,
                $statusName,
                $note,
            ];
        }

        $stream = fopen('php://temp', 'r+');
        $bom = "\xEF\xBB\xBF";
        fwrite($stream, $bom);
        foreach ($csvRows as $row) {
            fputcsv($stream, $row, ',');
        }
        rewind($stream);
        $csv = stream_get_contents($stream);
        fclose($stream);

        $suffix = $gender === 'male' ? '_男性' : ($gender === 'female' ? '_女性' : '');
        $filename = "参加者一覧_{$year}年{$suffix}.csv";

        $this->viewBuilder()->disableAutoLayout();
        return $this->response
            ->withStringBody($csv)
            ->withType('csv')
            ->withCharset('UTF-8')
            ->withHeader('Content-Disposition', 'attachment; filename*="UTF-8\'\'' . rawurlencode($filename) . '"');
    }

    /**
     * クラス別出欠状況管理
     * スタッフ・管理者のみアクセス可能
     */
    public function classAttendance(?int $class = null)
    {
        $currentRoleId = $this->getEffectiveRoleId();
        if ($currentRoleId === null) {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        if (!in_array($currentRoleId, [2, 3], true)) {
            $this->Flash->error('このページにアクセスする権限がありません。');
            return $this->redirect(['action' => 'regacy']);
        }

        // クラスが指定されていない場合はエラー
        if ($class === null) {
            $this->Flash->error('クラスが指定されていません。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $year = NEXT_YEAR;
        $service = new AttendanceUpdateService();
        $data = $service->getClassAttendanceData($class, $year);

        $this->set(compact('class', 'year'));
        $this->set($data);
    }

    /**
     * 個別メンバーの出欠状況編集ページ
     * スタッフ・管理者のみアクセス可能
     */
    public function editAttendance(?int $class = null, ?int $memberId = null)
    {
        $currentRoleId = $this->getEffectiveRoleId();
        if ($currentRoleId === null) {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        if (!in_array($currentRoleId, [2, 3], true)) {
            $this->Flash->error('このページにアクセスする権限がありません。');
            return $this->redirect(['action' => 'regacy']);
        }

        // クラスとメンバーIDが指定されていない場合はエラー
        if ($class === null || $memberId === null) {
            $this->Flash->error('パラメータが不正です。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $year = NEXT_YEAR;
        $service = new AttendanceUpdateService();
        $data = $service->getEditAttendanceData($memberId, $class, $year);

        if ($data['member'] === null) {
            $this->Flash->error('メンバーが見つかりません。');
            return $this->redirect(['action' => 'classAttendance', $class]);
        }

        $this->set(compact('class', 'year'));
        $this->set($data);
    }

    /**
     * 出欠状況を更新
     * スタッフ・管理者のみアクセス可能
     */
    public function updateAttendance()
    {
        $currentRoleId = $this->getEffectiveRoleId();
        if ($currentRoleId === null) {
            $this->Flash->error('ログインが必要です。');
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        if (!in_array($currentRoleId, [2, 3], true)) {
            $this->Flash->error('このページにアクセスする権限がありません。');
            return $this->redirect(['action' => 'regacy']);
        }

        $this->request->allowMethod(['post', 'put', 'patch']);

        $data = $this->request->getData();
        $memberId = (int)($data['member_id'] ?? 0);
        $class = (int)($data['class'] ?? 0);
        $rawStatusId = isset($data['attend_status_id']) ? (int)$data['attend_status_id'] : null;
        $attendStatusId = ($rawStatusId === null || $rawStatusId === -1) ? null : $rawStatusId;
        $note = $data['note'] ?? null;

        if ($memberId === 0 || $class === 0) {
            $this->Flash->error('不正なリクエストです。');
            return $this->redirect(['action' => 'dashboard']);
        }

        $year = NEXT_YEAR;
        $service = new AttendanceUpdateService();
        if (!$service->save($memberId, $year, $attendStatusId, $note)) {
            $this->Flash->error('出欠状況の保存に失敗しました。');
            return $this->redirect(['action' => 'editAttendance', $class, $memberId]);
        }

        $this->Flash->success('出欠状況を更新しました。');
        return $this->redirect(['action' => 'editAttendance', $class, $memberId]);
    }

}
