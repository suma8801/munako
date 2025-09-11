<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 'on');
set_time_limit(0);

session_start();
$link_logout = "";
$link = "";
$msg = "";
$name = "";

if (empty($_POST['password']) or empty($_POST['email'])){
    $msg = 'emailまたは、パスワードが入力されていません。';
    $link = '<a href="login_form.php">戻る</a>';
} else {
    $dsn = "mysql:host=183.90.241.215; dbname=semotion_weakness; charset=utf8";
    $username = "semotion_weaknes";
    $password = "94g02dji";

    try {
        $dbh = new PDO($dsn, $username, $password);
    } catch (Exception $e) {
        $msg = $e->getMessage();

    }
    
    $sql = "SELECT * FROM users WHERE email = :email";

    // var_dump($sql);
    // var_dump( $name);

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();

    $member = $stmt->fetch();
    
    
    //指定したハッシュがパスワードにマッチしているかチェック
    if (password_verify($_POST['password'], $member['password_hash'])) {
        //DBのユーザー情報をセッションに保存
        $_SESSION['id'] = $member['id'];
        $_SESSION['name'] = $member['name'];
       // リダイレクト先のURL
        $url = 'https://semotion.xsrv.jp/weakness/login_home.php';
        // リダイレクト
        header('Location: ' . $url);
    } else {
        $msg = 'EmailもしくはPasswordが間違っています。';
        $link = '<a href="login_form.php">戻る</a>';
    }
    
}
?>
<!-- <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>
<br>
<?php echo $link_logout; ?>
</body>
</html> -->

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインエラー</title>
    <!-- Bootstrap CSSの読み込み -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- エラーメッセージのアラート -->
                <div class="alert alert-danger" role="alert">
                <?php echo $msg; ?>
                </div>
                <!-- 戻るボタン -->
                <a href="login_form.php" class="btn btn-primary">ログイン画面に戻る</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScriptの読み込み -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-8aSrhW0F+5J4kXv/9Z7a5J5l5Lv8uStx5G8z5baNq3Y8zF4GIIvJh3yQ3V3DITdn" crossorigin="anonymous"></script>
</body>
</html>