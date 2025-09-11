<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content change-password">
    <h1><?= __('パスワード変更') ?></h1>
    
    <div class="change-password-form">
        <p class="form-description">
            <?= __($user->name.'さん、新しいパスワードを設定してください。') ?><br>
            <?= __('パスワードは8文字以上で、英数字を含む必要があります。') ?>
        </p>
        
        <?= $this->Form->create($user, ['url' => ['action' => 'changePassword']]) ?>
        <fieldset>
            <legend><?= __('パスワードを変更してください') ?></legend>
            
            <div class="input">
                <label for="current_password"><?= __('現在のパスワード') ?></label>
                <?= $this->Form->control('current_password', [
                    'type' => 'password',
                    'required' => true,
                    'placeholder' => '現在のパスワードを入力',
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
                <div class="help"><?= __('現在使用しているパスワードを入力してください') ?></div>
            </div>
            
            <div class="input">
                <label for="new_password"><?= __('新しいパスワード') ?></label>
                <?= $this->Form->control('new_password', [
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
                    'placeholder' => '新しいパスワードを再入力',
                    'label' => false,
                    'class' => 'form-control',
                    'minlength' => 8
                ]) ?>
                <div class="help"><?= __('上記と同じパスワードを入力してください') ?></div>
            </div>
        </fieldset>
        
        <div class="form-actions">
            <?= $this->Form->button(__('パスワードを変更'), ['class' => 'button']) ?>
            <?= $this->Html->link(__('ログインに戻る'), ['action' => 'logout'], ['class' => 'button button-outline']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?= $this->Html->css('mystyle') ?>
