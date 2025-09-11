<!DOCTYPE html>
<html lang="ja">
<head>
  <?= $this->Html->charset() ?>
  <title><?= $title ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="タロット ">
  <meta name="keywords" content="占い,結果">
  <?= $this->Html->css($style ?? 'prostyle') ?>

</head>
<body>
    <?php if (isset($showHamburger) && $showHamburger): ?>
    <!-- ハンバーガーメニュー -->
    <div class="hamburger-menu">
        <button class="hamburger-btn" onclick="toggleHamburgerMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="hamburger-content" id="hamburgerContent">
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>" class="hamburger-link">
                ユーザー登録
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <footer>
    </footer>
    
    <style>
    .hamburger-menu {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }
    
    .hamburger-btn {
        background: #333;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 4px;
    }
    
    .hamburger-btn span {
        width: 25px;
        height: 3px;
        background: white;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    
    .hamburger-content {
        position: absolute;
        top: 60px;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        min-width: 150px;
        display: none;
    }
    
    .hamburger-content.show {
        display: block;
    }
    
    .hamburger-link {
        display: block;
        padding: 12px 16px;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #eee;
    }
    
    .hamburger-link:hover {
        background: #f5f5f5;
    }
    
    .hamburger-link:last-child {
        border-bottom: none;
    }
    </style>
    
    <script>
    function toggleHamburgerMenu() {
        const content = document.getElementById('hamburgerContent');
        content.classList.toggle('show');
    }
    
    // メニュー外をクリックしたら閉じる
    document.addEventListener('click', function(event) {
        const menu = document.querySelector('.hamburger-menu');
        const content = document.getElementById('hamburgerContent');
        if (menu && !menu.contains(event.target)) {
            content.classList.remove('show');
        }
    });
    </script>
</body>
</html>
