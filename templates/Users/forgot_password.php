<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form content forgot-password">
    <h1><?= __('パスワードリセット') ?></h1>
    
    <div class="forgot-password-form">
        <p class="form-description">
            <?= __('パスワードを忘れた場合は、登録されているメールアドレスを入力してください。') ?><br>
            <?= __('パスワードリセット用のメールをお送りします。') ?>
        </p>
        
        <?= $this->Form->create(null, ['url' => ['action' => 'forgotPassword']]) ?>
        <fieldset>
            <legend><?= __('メールアドレスを入力してください') ?></legend>
            <div class="input">
                <label for="email"><?= __('メールアドレス') ?></label>
                <?= $this->Form->control('email', [
                    'type' => 'email',
                    'required' => true,
                    'placeholder' => 'example@example.com',
                    'label' => false,
                    'class' => 'form-control'
                ]) ?>
            </div>
        </fieldset>
        
        <div class="form-actions">
            <?= $this->Form->button(__('リセットメールを送信'), ['class' => 'button']) ?>
            <?= $this->Html->link(__('ログインページに戻る'), ['action' => 'login'], ['class' => 'button button-outline']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?= $this->Html->css('mystyle') ?>
