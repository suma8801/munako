<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 'on');
set_time_limit(0);

session_start();
$link_logout = "";
$link = "";
$msg = "";
$name = "";

if (empty($_POST['name']) or empty($_POST['email']) or empty($_POST['password'])){
    $msg = 'すべての項目を入力してください。';
    $link = '<a href="login_user_create_form.php">戻る</a>';
} else {

    try {
        //パスワードの暗号化
        $hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //$dsn = "mysql:host=127.0.0.1; dbname=boana_db; charset=utf8";
        $dsn = "mysql:host=183.90.241.215; dbname=semotion_weakness; charset=utf8";
        $username = "semotion_weaknes";
        $password = "94g02dji";
    

        // データベースへの接続開始
        $dbh = new PDO($dsn, $username, $password);
   
         // 事前にユーザーの存在を確認
        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':email', $_POST['email']);
        $sth->execute();
        $user_count = $sth->fetchColumn();
    
        if ($user_count > 0) {
            // 既に同じメールアドレスのユーザーが存在する場合の処理
            $msg = "同じメールアドレスのユーザーが既に存在しています。<br>別のメールアドレスで登録してください。";
        } else {
            // bindParamを利用したSQL文の実行
            $sql = 'INSERT INTO users (name, email, password_hash) VALUES(:name, :email, :pass);';
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':name', $_POST['name']);
            $sth->bindParam(':email', $_POST['email']);
            $sth->bindParam(':pass', $hash_pass);
            $sth->execute();

            $msg = "ユーザを正常に作成しました。";
        }
     
        // データベースへの接続に失敗した場合
    } catch (PDOException $e) {
        var_dump("error");
        $msg = "ユーザの登録に失敗しました。";
        $link = '<a href="login_user_create_form.php">ユーザ作成画面</a>';

        print('接続失敗:' . $e->getMessage());
        die();

        
    }

   
    $link = '<a href="login_form.php">ログイン画面</a>';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ作成処理結果</title>
</head>
<body>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>

</body>
</html>