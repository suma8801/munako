<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="home-page">
    <div class="welcome-container">
        <h1 class="welcome-title"><?= __('ようこそ') ?></h1>
        
        <div class="welcome-message">
            <p class="user-greeting">
                <?= __('ようこそ{0}、あなたは、{1}の参加者です。', 
                    h($user->name), 
                    h($course->name)
                ) ?>
            </p>
        </div>
        
        <div class="user-info">
            <div class="info-card">
                <h3><?= __('ユーザー情報') ?></h3>
                <div class="info-item">
                    <span class="label"><?= __('お名前:') ?></span>
                    <span class="value"><?= h($user->name) ?></span>
                </div>
                <div class="info-item">
                    <span class="label"><?= __('メールアドレス:') ?></span>
                    <span class="value"><?= h($user->email) ?></span>
                </div>
                <div class="info-item">
                    <span class="label"><?= __('コース:') ?></span>
                    <span class="value"><?= h($course->name) ?></span>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <?= $this->Html->link(__('プロフィール編集'), ['action' => 'edit'], ['class' => 'button button-primary']) ?>
            <?= $this->Html->link(__('パスワード変更'), ['action' => 'changePassword'], ['class' => 'button button-secondary']) ?>
            <?= $this->Html->link(__('ログアウト'), ['action' => 'logout'], ['class' => 'button button-outline']) ?>
        </div>
    </div>
</div>

<?= $this->Html->css('mystyle') ?>
