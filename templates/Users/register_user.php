<?php
/**
 * 一般ユーザー登録ページ
 * @var \App\View\AppView $this
 */
?>
<div class="users form content register-user-page">
    <div class="form-header">
        <h1><?= __('新規登録') ?></h1>
    </div>

    <?php if (!empty($oauthLoginProviders)) : ?>
    <p class="oauth-lead"><?= __('次のアカウントでログイン') ?></p>
    <div class="oauth-login-block" role="region" aria-label="<?= h(__('SNS・外部アカウントで登録')) ?>">
        <ul class="oauth-button-list">
            <?php foreach ($oauthLoginProviders as $p) :
                $slug = $p['slug'];
                ?>
            <li>
                <?= $this->Html->link(
                    $this->element('oauth_button_inner', ['slug' => $slug, 'buttonText' => $p['buttonText']]),
                    ['controller' => 'OAuth', 'action' => 'login', $slug],
                    [
                        'class' => 'oauth-button oauth-button--' . h($slug),
                        'escape' => false,
                        'rel' => 'nofollow',
                    ]
                ) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="register-or-divider" aria-hidden="true">
        <span><?= __('または') ?></span>
    </div>
    <?php endif; ?>

    <?= $this->Form->create($user, ['class' => 'register-form']) ?>
    <fieldset class="register-email-fieldset">
        <legend class="register-email-legend"><?= __('メールアドレスで登録') ?></legend>

        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('email', [
                    'label' => __('メールアドレス'),
                    'type' => 'email',
                    'required' => true,
                    'placeholder' => 'example@example.com',
                    'class' => 'form-control',
                ]) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <?= $this->Form->control('password', [
                    'label' => __('パスワード'),
                    'type' => 'password',
                    'required' => true,
                    'placeholder' => __('パスワードを入力'),
                    'class' => 'form-control',
                ]) ?>
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <?= $this->Form->button(__('登録'), ['class' => 'button button-primary']) ?>
    </div>
    <?= $this->Form->end() ?>

    <p class="register-user-sub-actions">
        <?= $this->Html->link(__('キャンセル'), ['controller' => 'Homes', 'action' => 'index'], ['class' => 'button button-outline']) ?>
    </p>

    <p class="register-user-footer-link">
        <?= $this->Html->link(__('すでにアカウントをお持ちの方はログイン'), ['action' => 'loginUser'], ['class' => 'text-link-underline']) ?>
    </p>
</div>

<?= $this->Html->css('mystyle') ?>
