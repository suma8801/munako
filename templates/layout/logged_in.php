<?php
/**
 * ログイン状態のレイアウト
 */
?><!DOCTYPE html>
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'mystyle']) ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha384-Q/b68FXi/uzI6bjcGbx7kHAobgdK2x1qOUrqdTvipaJci87t0PRovmYAIrCVE4x5" crossorigin="anonymous">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a href="<?= $this->Url->build(['controller' => 'Homes', 'action' => 'index']) ?>" class="brand-link">
                        <?= $this->Html->image('favicon.ico', ['alt' => '宗像高校同窓会', 'class' => 'brand-logo']) ?>
                        <span class="brand-text">宗像高校同窓会</span>
                    </a>
                </div>
                <div class="navbar-menu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Homes', 'action' => 'index']) ?>" class="nav-link">ホーム</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="nav-link">ログアウト</a>
                        </li>
                    </ul>
                    <button class="navbar-toggle" aria-label="メニューを開く">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <?= $this->fetch('content') ?>
    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>宗像高校同窓会</h3>
                    <p>昭和56年卒業生の皆様のための同窓会サイトです。</p>
                </div>
                <div class="footer-section">
                    <h4>リンク</h4>
                    <ul class="footer-links">
                        <li><a href="<?= $this->Url->build(['controller' => 'Homes', 'action' => 'index']) ?>">ホーム</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">ログイン</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>">新規登録</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>お問い合わせ</h4>
                    <p>suma8801@gmail.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 ymatsu. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>