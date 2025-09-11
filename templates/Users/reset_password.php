<?php
/**
 * @var \App\View\AppView $this
 * @var string $token
 */
?>
<div class="users form content reset-password">
    <h1><?= __('パスワードリセット') ?></h1>
    
    <div class="reset-password-form">
        <p class="form-description">
            <?= __('新しいパスワードを設定してください。') ?><br>
            <?= __('パスワードは8文字以上で、英数字を含む必要があります。') ?>
        </p>
        
        <?= $this->Form->create(null, ['url' => ['action' => 'resetPassword', $token]]) ?>
        <fieldset>
            <legend><?= __('新しいパスワードを入力してください') ?></legend>
            
            <div class="input">
                <label for="password"><?= __('新しいパスワード') ?></label>
                <?= $this->Form->control('password', [
                    'type' => 'password',
                    'required' => true,
                    'placeholder' => '新しいパスワードを入力',
                    'label' => false,
                    'class' => 'form-control',
                    'minlength' => 8
                ]) ?>
                <div class="help"><?= __('8文字以上で入力してください') ?></div>
            </div>
            
            <div class="input">
                <label for="confirm_password"><?= __('パスワード（確認）') ?></label>
                <?= $this->Form->control('confirm_password', [
                    'type' => 'password',
                    'required' => true,
                    'placeholder' => 'パスワードを再入力',
                    'label' => false,
                    'class' => 'form-control',
                    'minlength' => 8
                ]) ?>
                <div class="help"><?= __('上記と同じパスワードを入力してください') ?></div>
            </div>
            
            <?= $this->Form->hidden('token', ['value' => $token]) ?>
        </fieldset>
        
        <div class="form-actions">
            <?= $this->Form->button(__('パスワードを変更'), ['class' => 'button']) ?>
            <?= $this->Html->link(__('ログインページに戻る'), ['action' => 'login'], ['class' => 'button button-outline']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?= $this->Html->css('mystyle') ?>
