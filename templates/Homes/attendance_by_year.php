<div class="attendance-by-year-page">
    <div class="page-header">
        <h1><?= h($year) ?>年 参加者一覧<?php if ($gender === 'male'): ?>（男性）<?php elseif ($gender === 'female'): ?>（女性）<?php endif; ?></h1>
        <p class="page-subtitle">開催年ごとの参加者（グラフの棒をクリックで表示）</p>
        <div class="header-actions">
            <?php if (!empty($records)): ?>
                <?php
                $csvUrl = ['action' => 'attendanceByYearCsv', $year];
                if (!empty($gender)) {
                    $csvUrl['?'] = ['gender' => $gender];
                }
                ?>
                <a href="<?= $this->Url->build($csvUrl) ?>" class="btn btn-primary btn-csv">CSVで保存</a>
            <?php endif; ?>
            <a href="<?= $this->Url->build(['action' => 'dashboard']) ?>" class="btn btn-secondary btn-back">ダッシュボードに戻る</a>
        </div>
    </div>

    <?php if (!empty($records)): ?>
        <div class="attendance-table-container">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>クラス</th>
                        <th>番号</th>
                        <th>名前</th>
                        <th>性別</th>
                        <th>出欠状況</th>
                        <th>メモ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <?php
                        $member = $record->member;
                        $statusName = $record->attend_status ? $record->attend_status->name : '--';
                        $sexLabel = $member->sex == 1 ? '男性' : '女性';
                        $note = $record->note ?? '';
                        $truncatedNote = mb_strlen($note) > 20 ? mb_substr($note, 0, 20) . '...' : $note;
                        ?>
                        <tr>
                            <td><?= h($member->class) ?>組</td>
                            <td><?= h($member->no) ?></td>
                            <td><?= h($member->name) ?></td>
                            <td><?= h($sexLabel) ?></td>
                            <td><span class="status-text"><?= h($statusName) ?></span></td>
                            <td><span class="note-text"><?= $note ? h($truncatedNote) : '--' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <?= h($year) ?>年の参加者データはありません。
        </div>
    <?php endif; ?>
</div>

<?php
$this->start('css');
?>
<style>
.attendance-by-year-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.attendance-by-year-page .page-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.attendance-by-year-page .page-header h1 {
    color: #007cba;
    font-size: 2rem;
    font-weight: 600;
    margin: 0;
}

.attendance-by-year-page .page-subtitle {
    color: #666;
    font-size: 1.1rem;
    margin: 0.5rem 0 0 0;
}

.attendance-by-year-page .header-actions {
    margin-top: auto;
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.attendance-by-year-page .btn-primary {
    background: #007cba;
    color: white;
}

.attendance-by-year-page .btn-primary:hover {
    background: #005a87;
    color: white;
    text-decoration: none;
}

.attendance-by-year-page .btn {
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

.attendance-by-year-page .btn-secondary {
    background: #6c757d;
    color: white;
}

.attendance-by-year-page .btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.attendance-by-year-page .attendance-table-container {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow-x: auto;
}

.attendance-by-year-page .attendance-table {
    width: 100%;
    border-collapse: collapse;
}

.attendance-by-year-page .attendance-table thead {
    background: #f8f9fa;
}

.attendance-by-year-page .attendance-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
    font-size: 1.3rem;
}

.attendance-by-year-page .attendance-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    font-size: 1.3rem;
}

.attendance-by-year-page .attendance-table tbody tr:hover {
    background: #f8f9fa;
}

.attendance-by-year-page .status-text,
.attendance-by-year-page .note-text {
    display: inline-block;
    padding: 0.25rem 0;
}

.attendance-by-year-page .alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

.attendance-by-year-page .alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

@media (max-width: 768px) {
    .attendance-by-year-page {
        padding: 1rem 0.5rem;
    }

    .attendance-by-year-page .attendance-table-container {
        padding: 1rem;
    }

    .attendance-by-year-page .attendance-table {
        font-size: 0.9rem;
    }

    .attendance-by-year-page .attendance-table th,
    .attendance-by-year-page .attendance-table td {
        padding: 0.5rem;
    }

    .attendance-by-year-page .page-header {
        flex-direction: column;
    }
}
</style>
<?php
$this->end();
?>
