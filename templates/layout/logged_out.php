<?php
/**
 * ログアウト状態のレイアウト
 */
?><!DOCTYPE html>
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'mystyle']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        
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