<div class="edit-attendance-page">
    <div class="page-header">
        <h1><?= h($member->name) ?> さんの出欠状況編集</h1>
        <p class="page-subtitle"><?= h($class) ?>組 / <?= NEXT_YEAR ?>年度（次回同窓会）</p>
        <div class="header-actions">
            <a href="<?= $this->Url->build(['action' => 'classAttendance', $class]) ?>" class="btn btn-secondary btn-back">一覧に戻る</a>
        </div>
    </div>

    <div class="edit-form-container">
        <?= $this->Form->create(null, [
            'url' => ['action' => 'updateAttendance'],
            'class' => 'attendance-edit-form',
            'id' => 'attendance-form'
        ]) ?>
            <?= $this->Form->hidden('member_id', ['value' => $member->id]) ?>
            <?= $this->Form->hidden('class', ['value' => $class]) ?>

            <div class="form-group">
                <?php
                $currentStatusId = $attendance->attend_status_id ?? null;
                $statusOptions = ['' => '-- 選択してください --'];
                foreach ($attendStatuses as $status) {
                    $statusOptions[$status->id] = $status->name;
                }
                ?>
                <?= $this->Form->label('attend_status_id', '出欠状況') ?>
                <?= $this->Form->control('attend_status_id', [
                    'type' => 'select',
                    'options' => $statusOptions,
                    'value' => $currentStatusId,
                    'label' => false,
                    'class' => 'form-control status-select',
                    'required' => false,
                    'data-original-value' => $currentStatusId
                ]) ?>
            </div>

            <div class="form-group">
                <?php
                $currentNote = $attendance->note ?? '';
                ?>
                <?= $this->Form->label('note', 'メモ') ?>
                <?= $this->Form->control('note', [
                    'type' => 'textarea',
                    'value' => $currentNote,
                    'label' => false,
                    'class' => 'form-control note-textarea',
                    'rows' => 4,
                    'placeholder' => 'メモを入力してください',
                    'data-original-value' => $currentNote
                ]) ?>
            </div>

            <div class="form-actions">
                <?= $this->Form->button('保存', [
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-save'
                ]) ?>
                <a href="<?= $this->Url->build(['action' => 'classAttendance', $class]) ?>" class="btn btn-secondary btn-back">キャンセル</a>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php
$this->start('css');
?>
<style>
.edit-attendance-page {
    max-width: 600px;
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
    font-size: 1.75rem;
    font-weight: 600;
    margin: 0;
}

.page-subtitle {
    color: #666;
    font-size: 1rem;
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

.edit-form-container {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.form-group {
    margin-bottom: 2rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 1rem;
    box-sizing: border-box;
}

.status-select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.status-select::-ms-expand {
    display: none;
}

.note-textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
    line-height: 1.5;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.form-actions .btn {
    flex: 1;
    text-align: center;
}

@media (max-width: 768px) {
    .edit-attendance-page {
        padding: 1rem 0.5rem;
    }

    .edit-form-container {
        padding: 1.5rem;
    }

    .page-header {
        flex-direction: column;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>
<?php
$this->end();
?>

<?php
$this->start('script');
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let hasUnsavedChanges = false;
    const form = document.getElementById('attendance-form');
    const statusSelect = form.querySelector('.status-select');
    const noteTextarea = form.querySelector('.note-textarea');

    const originalStatusValue = statusSelect.getAttribute('data-original-value') || '';
    const originalNoteValue = noteTextarea.getAttribute('data-original-value') || '';

    // 変更検知
    function checkForChanges() {
        const currentStatusValue = statusSelect.value || '';
        const currentNoteValue = noteTextarea.value || '';
        
        hasUnsavedChanges = (currentStatusValue !== originalStatusValue) || 
                           (currentNoteValue !== originalNoteValue);
    }

    statusSelect.addEventListener('change', checkForChanges);
    noteTextarea.addEventListener('input', checkForChanges);

    // フォーム送信時は変更フラグをリセット
    form.addEventListener('submit', function() {
        hasUnsavedChanges = false;
    });

    // ページ離脱時の確認
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '保存されていない変更があります。このページを離れますか？';
            return e.returnValue;
        }
    });

    // 戻るリンクのクリック時も確認
    document.querySelectorAll('.btn-back').forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (hasUnsavedChanges) {
                if (!confirm('保存されていない変更があります。このページを離れますか？')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
});
</script>
<?php
$this->end();
?>


