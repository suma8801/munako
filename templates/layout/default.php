<?php
/**
 * 宗像高校同窓会
 *
 * @copyright     Copyright (c) ymatsu
 * @link          
 * @since         2025/09/11
 * @license       
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $description ?? '宗像高校同窓会' ?>">
    <meta name="keywords" content="<?= $keywords ?? '宗像,高校,同窓会' ?>">
    <meta name="author" content="<?= $author ?? 'ymatsu' ?>">
    <meta name="robots" content="<?= $robots ?? 'index, follow' ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha384-Q/b68FXi/uzI6bjcGbx7kHAobgdK2x1qOUrqdTvipaJci87t0PRovmYAIrCVE4x5" crossorigin="anonymous">
-->
    <?= $this->Html->css('m_style'); ?>
    
    <title>
        <?= $this->fetch('title') ? $this->fetch('title') . ' - ' : '' ?>
        <?= $description ?? '宗像高校同窓会' ?>
    </title>
    
    <?= $this->Html->meta('icon', $this->Url->build(DS . 'img' . DS . 'favicon.ico')) ?>
    <?= $this->Html->meta('apple-touch-icon', $this->Url->build(DS . 'img' . DS . 'favicon.ico')) ?>
    <?= $this->Html->meta('canonical', $canonical ?? '') ?>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $this->Url->build('/', ['fullBase' => true]) ?>">
    <meta property="og:title" content="<?= $og_title ?? $this->fetch('title') ?>">
    <meta property="og:description" content="<?= $description ?? '宗像高校同窓会' ?>">
    <meta property="og:image" content="<?= $this->Url->build(DS . 'img' . DS . 'favicon.ico', ['fullBase' => true]) ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= $this->Url->build('/', ['fullBase' => true]) ?>">
    <meta property="twitter:title" content="<?= $og_title ?? $this->fetch('title') ?>">
    <meta property="twitter:description" content="<?= $description ?? '宗像高校同窓会' ?>">
    <meta property="twitter:image" content="<?= $this->Url->build(DS . 'img' . DS . 'favicon.ico', ['fullBase' => true]) ?>">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'mystyle']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <!-- ナビゲーションヘッダー -->
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
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="nav-link">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>" class="nav-link">新規登録</a>
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

    <!-- メインコンテンツ -->
    <main class="main-content">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>

    <!-- フッター -->
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

    <!-- JavaScript -->
     <!--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
-->
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
    </script>
    <script>
        // ナビゲーションメニューのトグル
        $(function() {
            $('.navbar-toggle').on('click', function() {
                $('.navbar-menu').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>
</body>
</html>
