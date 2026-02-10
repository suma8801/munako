<div class="class-attendance-page">
    <div class="page-header">
        <h1><?= h($class) ?>組 出欠状況管理</h1>
        <p class="page-subtitle"><?= NEXT_YEAR ?>年度（次回同窓会）</p>
        <div class="header-actions">
            <a href="<?= $this->Url->build(['action' => 'dashboard']) ?>" class="btn btn-secondary btn-back">ダッシュボードに戻る</a>
        </div>
    </div>

    <?php if (!empty($members)): ?>
        <div class="attendance-table-container">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>番号</th>
                        <th>名前</th>
                        <th>性別</th>
                        <th>出欠状況</th>
                        <th>メモ</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                        <?php
                        $attendance = $attendances[$member->id] ?? null;
                        $currentStatusId = $attendance->attend_status_id ?? null;
                        $currentNote = $attendance->note ?? '';
                        $sexLabel = $member->sex == 1 ? '男性' : '女性';
                        
                        // 出欠ステータス名を取得
                        $currentStatusName = '';
                        if ($currentStatusId && isset($attendStatuses)) {
                            foreach ($attendStatuses as $status) {
                                if ($status->id == $currentStatusId) {
                                    $currentStatusName = $status->name;
                                    break;
                                }
                            }
                        }
                        $truncatedNote = mb_strlen($currentNote) > 20 ? mb_substr($currentNote, 0, 20) . '...' : $currentNote;
                        ?>
                        <tr>
                            <td><?= h($member->no) ?></td>
                            <td><?= h($member->name) ?></td>
                            <td><?= h($sexLabel) ?></td>
                            <td>
                                <span class="status-text"><?= $currentStatusName ? h($currentStatusName) : '--' ?></span>
                            </td>
                            <td>
                                <span class="note-text"><?= $currentNote ? h($truncatedNote) : '--' ?></span>
                            </td>
                            <td>
                                <a href="<?= $this->Url->build(['action' => 'editAttendance', $class, $member->id]) ?>" class="btn btn-primary btn-edit-link">編集</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            このクラスのメンバーが見つかりませんでした。
        </div>
    <?php endif; ?>
</div>


<?php
$this->start('css');
?>
<style>
.class-attendance-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.page-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header h1 {
    color: #007cba;
    font-size: 2rem;
    font-weight: 600;
    margin: 0;
}

.page-subtitle {
    color: #666;
    font-size: 1.1rem;
    margin: 0.5rem 0 0 0;
}

.header-actions {
    margin-top: auto;
}

.btn {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.btn-primary {
    background: #007cba;
    color: white;
}

.btn-primary:hover {
    background: #005a87;
    color: white;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
    color: white;
}

.btn-sm {
    padding: 0.25rem 1rem;
    font-size: 0.875rem;
}

.btn-edit-link {
    padding: 0.5rem 1.25rem;
    font-size: 1rem;
}

.attendance-table-container {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow-x: auto;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
}

.attendance-table thead {
    background: #f8f9fa;
}

.attendance-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
    font-size: 1.3rem;
}

.attendance-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    font-size: 1.3rem;
}

.attendance-table tbody tr:hover {
    background: #f8f9fa;
}

.status-text, .note-text {
    display: inline-block;
    padding: 0.25rem 0;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 0.95rem;
}

.status-select {
    min-width: 150px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.status-select::-ms-expand {
    display: none;
}

.note-input {
    min-width: 200px;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

.alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

@media (max-width: 768px) {
    .class-attendance-page {
        padding: 1rem 0.5rem;
    }

    .attendance-table-container {
        padding: 1rem;
    }

    .attendance-table {
        font-size: 0.9rem;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 0.5rem;
    }

    .page-header {
        flex-direction: column;
    }
}
</style>
<?php
$this->end();
?>

