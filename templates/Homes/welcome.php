<?php
// ログイン後最初のページ
/**
 * @var \App\View\AppView $this
 */
?>
<div class="pages contants">
    <h1>ようこそ</h1>
    
    <?= $this->Form->create() ?>
    
    <div class="form-actions">
        <?= $this->Form->button(__('生年月日の入力'), ['class' => 'button']) ?>
        <br/>
        <?= $this->Form->button(__('登録データから選ぶ'), ['class' => 'button']) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>

<?= $this->Html->css('mystyle') ?>

