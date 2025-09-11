<?php

// データベース接続情報
$dsn = "mysql:host=183.90.241.215; dbname=semotion_weakness; charset=utf8";
$username = "semotion_weaknes";
$password = "94g02dji";

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo 'エラーです。';
        return;
    }

    if (empty($_POST['email'])) {
        echo 'エラーです。';
        return;
    }

    // データベース接続
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // メールアドレスを取得
    $mailto = $_POST['email'] ?? ''; // PHP 7.0+ のnull合体演算子を使用

    if (!empty($mailto)) {
        // データベースでメールアドレスを検索
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$mailto]);
        $user = $stmt->fetch();

        if ($user) {
            // トークン生成
            $token = bin2hex(random_bytes(32));
            // 有効期限を現在時刻から1時間後に設定
            $tokenExpiry = date('Y-m-d H:i:s', time() + 3600); // 3600秒 = 1時間

            // トークンと有効期限をデータベースに保存
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
            $stmt->execute([$token, $tokenExpiry, $mailto]);

            // メール内容
            $subject = "愛の天命タロット:ログインパスワード変更";
            $content = "パスワード変更URLリンクはこちらから:\r\nhttps://semotion.xsrv.jp/weakness/password_reset.php?token=$token";
            $mailfrom = "From:steushyd@semotion.xsrv.jp";

            mb_internal_encoding("UTF-8");
            if (mb_send_mail($mailto, $subject, $content, $mailfrom)) {
                $message = "送信成功しました。メールをご確認ください。";
            } else {
                $message = "送信失敗しました。";
            }
        } else {
            $message = "メールアドレスが登録されていません。";
        }
    } else {
        $message = "メールアドレスが入力されていません。";
    }
} catch (Exception $e) {
    $message = 'エラーが発生しました: ' . $e->getMessage();
}

// 以下はHTMLとBootstrapを用いたメッセージ表示部分
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>パスワードリセット結果</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-info mt-5" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <a href="password_reset_form.php" class="btn btn-primary">戻る</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
