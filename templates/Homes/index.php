<?php
// ログイン後最初のページ
/**
 * @var \App\View\AppView $this
 */
?>
<div class="home-page">
    <div class="hero-section">
        <div class="hero-content">
            <h1 id="h1_hero-subtitle" class="hero-title">ようこそ宗高S56年卒業生の皆様</h1>
            <p class="hero-subtitle">昭和56年卒業生の皆様のための同窓会サイトへようこそ</p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= date('Y') - 1981 ?></span>
                    <span class="stat-label">年前</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">S56年</span>
                    <span class="stat-label">卒業</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">宗像</span>
                    <span class="stat-label">高校</span>
                </div>
            </div>
        </div>
    </div>

    <div class="welcome-section">
        <div class="welcome-container">
            <div class="welcome-message">
                <h2>同窓会サイトへようこそ</h2>
                <p>昭和56年卒業生の皆様、お疲れ様です。このサイトでは、同窓生の皆様との交流や情報共有ができます。</p>
            </div>
            
            <div class="login-options">
                <h3>ログイン方法を選択してください</h3>
                <div class="login-cards">
                    <div class="login-card">
                        <div class="card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <h4>一般ログイン</h4>
                        <p>同窓生の皆様はこちらからログインしてください</p>
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'Users', 'action' => 'login'], 
                            'class' => 'login-form',
                            'method' => 'get'
                        ]) ?>
                        <?= $this->Form->button(__('一般ログイン'), ['class' => 'button button-primary button-large']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    
                    <div class="login-card">
                        <div class="card-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <h4>スタッフログイン</h4>
                        <p>運営スタッフの方はこちらからログインしてください</p>
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'Users', 'action' => 'login'], 
                            'class' => 'login-form',
                            'method' => 'get'
                        ]) ?>
                        <?= $this->Form->button(__('スタッフログイン'), ['class' => 'button button-secondary button-large']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="container">
            <h2>サイトの機能</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3>同窓生検索</h3>
                    <p>同窓生の連絡先や近況を検索できます</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3>メッセージ</h3>
                    <p>同窓生同士でメッセージのやり取りができます</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3>イベント情報</h3>
                    <p>同窓会や懇親会の情報をお知らせします</p>
                </div>
            </div>
        </div>
    </div>
</div>

