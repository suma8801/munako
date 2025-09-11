
<?php
session_start();
$username = $_SESSION['name'];
if (isset($_SESSION['id'])) {//ログインしているとき
    $msg = 'こんにちは' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さん';
    $link = '<a href="logout_exec.php">ログアウト</a>';
} else {//ログインしていない時
    $msg = 'ログインしていません';
    $link = '<a href="login_form.php">ログイン</a>';
    // リダイレクト先のURL
    $url = 'https://semotion.xsrv.jp/weakness/login_form.php';
    // リダイレクト
    header('Location: ' . $url);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>占い結果</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="占い結果表示ページ">
  <meta name="keywords" content="占い,結果">
  <link rel="stylesheet" type="text/css" href="proresultstyles.css">
</head>
<body>
    <h1>あなたの<br><br>才能は...</h1>
          <div class="result-content">
            <h2 id="talent-title"></h2>
            <div class="result-row">
              <img id="talent-image" src="" alt="Tarot Card Image">
              <div id="talent-short-text"></div>
            </div>
            <div id="talent-long-text"></div>
          </div>
          <h1>あなたの<br><br>弱点は...</h1>
          <div class="result-content">
            <h2 id="weakness-title"></h2>
            <div class="result-row">
              <img id="weakness-image" src="" alt="Tarot Card Image">
              <div id="weakness-short-text"></div>
            </div>
            <div id="weakness-long-text"></div>
          </div>
          <h1>あなたの<br><br>天命は...</h1>
          <div class="result-content">
                 <h2 id="destiny-title"></h2>
                 <div class="result-row">
                   <img id="destiny-image" src="" alt="Tarot Card Image">
                   <div id="destiny-short-text"></div>
                 </div>
                 <div id="destiny-long-text"></div>
               </div>
          <!-- 現在の弱点の結果セクションの下に追加 -->
            <div class="result-content" id="second-weakness-section" style="display: none;">
              <h1>もう1つのあなたの<br><br>弱点は...</h1>
              <h2 id="second-weakness-title"></h2>
              <div class="result-row">
                  <img id="second-weakness-image" src="" alt="Tarot Card Image">
                  <div id="second-weakness-short-text"></div>
              </div>
              <div id="second-weakness-long-text"></div>
            </div>
        
    </div>

  <script src="proresult.js"></script>
</body>
</html>
