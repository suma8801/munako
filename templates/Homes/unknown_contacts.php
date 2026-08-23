<div class="unknown-contacts-page">
    <div class="page-header">
        <div class="page-header-left">
            <h1>連絡先不明の同窓生</h1>
            <p class="page-subtitle"><?= h($year) ?>年度（次回同窓会） / <?= count($records) ?>名</p>
        </div>
    </div>

    <p class="page-lead">
        現在、連絡先が分からない同窓生の一覧です。<br>
        お心当たりがある方がいらっしゃいましたら、スタッフまでお知らせください。<br>
        連絡先: <a href="mailto:suma8801@gmail.com">suma8801@gmail.com</a>
    </p>

    <?php if (!empty($records)): ?>
        <div class="attendance-table-container">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>クラス</th>
                        <th>番号</th>
                        <th>名前</th>
                        <th>よみがな</th>
                        <?php if (($effectiveRoleId ?? null) !== null && in_array((int)$effectiveRoleId, [2, 3], true)): ?>
                            <th>操作</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <?php $member = $record->member; ?>
                        <?php if ($member === null) { continue; } ?>
                        <tr>
                            <td><?= h($member->class) ?>組</td>
                            <td><?= h($member->no) ?></td>
                            <td><?= h($member->name) ?></td>
                            <td><?= h($member->yomi) ?></td>
                            <?php if (($effectiveRoleId ?? null) !== null && in_array((int)$effectiveRoleId, [2, 3], true)): ?>
                                <td>
                                    <a href="<?= $this->Url->build(['action' => 'editAttendance', $member->class, $member->id]) ?>" class="btn btn-primary btn-edit-link">編集</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            現在、連絡先不明として登録されている方はいません。
        </div>
    <?php endif; ?>
</div>

<?php
$this->start('css');
?>
<style>
.unknown-contacts-page {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.unknown-contacts-page .page-header {
    margin-bottom: 1.25rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e9ecef;
}

.unknown-contacts-page .page-header h1 {
    color: #007cba;
    font-size: 2rem;
    font-weight: 600;
    margin: 0;
}

.unknown-contacts-page .page-subtitle {
    color: #666;
    font-size: 1.1rem;
    margin: 0.5rem 0 0 0;
}

.unknown-contacts-page .page-lead {
    color: #333;
    font-size: 1rem;
    line-height: 1.8;
    margin: 0 0 1.5rem 0;
}

.unknown-contacts-page .page-lead a {
    color: #007cba;
}

.unknown-contacts-page .attendance-table-container {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow-x: auto;
}

.unknown-contacts-page .attendance-table {
    width: 100%;
    border-collapse: collapse;
}

.unknown-contacts-page .attendance-table thead {
    background: #f8f9fa;
}

.unknown-contacts-page .attendance-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
    font-size: 1.25rem;
}

.unknown-contacts-page .attendance-table td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    font-size: 1.25rem;
}

.unknown-contacts-page .attendance-table tbody tr:hover {
    background: #f8f9fa;
}

.unknown-contacts-page .btn {
    display: inline-block;
    padding: 0.5rem 1.25rem;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.unknown-contacts-page .btn-primary {
    background: #007cba;
    color: white;
}

.unknown-contacts-page .btn-primary:hover {
    background: #005a87;
    color: white;
    text-decoration: none;
}

.unknown-contacts-page .alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin: 2rem 0;
}

.unknown-contacts-page .alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

@media (max-width: 768px) {
    .unknown-contacts-page {
        padding: 1rem 0.5rem;
    }

    .unknown-contacts-page .attendance-table-container {
        padding: 1rem;
    }

    .unknown-contacts-page .attendance-table th,
    .unknown-contacts-page .attendance-table td {
        padding: 0.5rem;
        font-size: 1rem;
    }
}
</style>
<?php
$this->end();
?>
