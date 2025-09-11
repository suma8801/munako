<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form content">
    <h1><?= __('ユーザー登録') ?></h1>
    
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('新規ユーザー情報を入力してください') ?></legend>
        <?= $this->Form->control('email', [
            'label' => 'メールアドレス',
            'type' => 'email',
            'required' => true,
            'placeholder' => 'example@example.com',
            'help' => 'ログイン時に使用するメールアドレスを入力してください'
        ]) ?>
        <?= $this->Form->control('name', [
            'label' => '氏名',
            'type' => 'text',
            'required' => true,
            'placeholder' => '山田太郎',
            'help' => 'フルネームを入力してください'
        ]) ?>
        <?= $this->Form->control('yomi', [
            'label' => 'よみがな',
            'type' => 'text',
            'required' => true,
            'placeholder' => 'やまだたろう',
            'help' => 'ひらがなでよみがなを入力してください'
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => 'パスワード',
            'type' => 'password',
            'required' => true,
            'placeholder' => '8文字以上で入力',
            'help' => '8文字以上の英数字を入力してください'
        ]) ?>
        <?= $this->Form->control('password_confirm', [
            'label' => 'パスワード（確認）',
            'type' => 'password',
            'required' => true,
            'placeholder' => 'パスワードを再入力',
            'help' => '同じパスワードをもう一度入力してください'
        ]) ?>
        <?php
        // 初回登録時（管理者未作成）は管理者固定表示
        if (isset($hasAdmin) && !$hasAdmin) {
            echo $this->Form->control('role_id', [
                'label' => '権限',
                'type' => 'text',
                'value' => '管理者',
                'disabled' => true
            ]);
            echo $this->Form->hidden('role_id', ['value' => 3]);
        } else {
            echo $this->Form->control('role_id', [
                'label' => '権限',
                'type' => 'select',
                'options' => $roles ?? [],
                'empty' => '-- 選択してください --',
                'required' => true
            ]);
        }
        ?>
        <?= $this->Form->control('plan_id', [
            'label' => 'プラン',
            'type' => 'select',
            'options' => $plans ?? [],
            'empty' => '-- 選択してください --',
            'required' => true
        ]) ?>
        <?= $this->Form->control('course_id', [
            'label' => 'コース',
            'type' => 'select',
            'options' => $courses ?? [],
            'empty' => '-- 選択してください --',
            'required' => true
        ]) ?>
        <?= $this->Form->control('expire', [
            'label' => '有効期限',
            'type' => 'datetime',
            'required' => true
        ]) ?>
    </fieldset>
    
    <div class="form-actions">
        <?= $this->Form->button(__('登録'), ['class' => 'button']) ?>
        <?= $this->Html->link(__('トップへ'), ['controller' => 'Pages', 'action' => 'home'], ['class' => 'button button-outline']) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>

<?= $this->Html->css('mystyle') ?>
