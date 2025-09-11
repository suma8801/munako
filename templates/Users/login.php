<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content login">
    <?php
        echo $this->Html->image('loginimage.png', [
            'alt' => 'ログインイメージ',
            'class' => 'login-image'
        ]);
    ?>
    <h1><?= __('ログイン') ?></h1>
    
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('ログイン情報を入力してください') ?></legend>
        <?= $this->Form->control('email', [
            'label' => 'メールアドレス',
            'type' => 'email',
            'required' => true,
            'placeholder' => 'example@example.com'
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => 'パスワード',
            'type' => 'password',
            'required' => true,
            'placeholder' => 'パスワードを入力'
        ]) ?>
    </fieldset>
    
    <div class="form-actions">
        <?= $this->Form->button(__('ログイン'), ['class' => 'button']) ?>
        <br/>
        <?= $this->Html->link(__('パスワードを忘れた方'), ['action' => 'forgotPassword'], ['class' => 'text-link-underline small-text']) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>

<?= $this->Html->css('mystyle') ?>
