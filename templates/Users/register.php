<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form content">
    <div class="form-header">
        <h1><?= __('ユーザー登録') ?></h1>
        <p class="form-description">新規ユーザーの情報を入力してください</p>
    </div>
    
    <?= $this->Form->create(null, ['class' => 'register-form']) ?>
    <fieldset>
        <legend><?= __('基本情報') ?></legend>
        
        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('email', [
                    'label' => 'メールアドレス',
                    'type' => 'email',
                    'required' => true,
                    'placeholder' => 'example@example.com',
                    'help' => 'ログイン時に使用するメールアドレスを入力してください',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('name', [
                    'label' => '氏名',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => '山田太郎',
                    'help' => 'フルネームを入力してください',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('yomi', [
                    'label' => 'よみがな',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'やまだたろう',
                    'help' => 'ひらがなでよみがなを入力してください',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('password', [
                    'label' => 'パスワード',
                    'type' => 'password',
                    'required' => true,
                    'placeholder' => '8文字以上で入力',
                    'help' => '8文字以上の英数字を入力してください',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('password_confirm', [
                    'label' => 'パスワード（確認）',
                    'type' => 'password',
                    'required' => true,
                    'placeholder' => 'パスワードを再入力',
                    'help' => '同じパスワードをもう一度入力してください',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
    </fieldset>
    
    <fieldset>
        <legend><?= __('権限・設定') ?></legend>
        
        <div class="form-row">
            <div class="form-group">
                <?php
                // 初回登録時（管理者未作成）は管理者固定表示
                if (isset($hasAdmin) && !$hasAdmin) {
                    echo $this->Form->control('role_id', [
                        'label' => '権限',
                        'type' => 'text',
                        'value' => '管理者',
                        'disabled' => true,
                        'class' => 'form-control'
                    ]);
                    echo $this->Form->hidden('role_id', ['value' => 3]);
                } else {
                    echo $this->Form->control('role_id', [
                        'label' => '権限',
                        'type' => 'select',
                        'options' => $roles ?? [],
                        'empty' => '-- 選択してください --',
                        'required' => true,
                        'class' => 'form-control',
                        'help' => 'ユーザーの権限レベルを選択してください'
                    ]);
                }
                ?>
            </div>
        </div>
        
    </fieldset>
    
    <div class="form-actions">
        <?= $this->Form->button(__('登録'), ['class' => 'button button-primary']) ?>
        <?= $this->Html->link(__('キャンセル'), ['controller' => 'Homes', 'action' => 'index'], ['class' => 'button button-outline']) ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>
