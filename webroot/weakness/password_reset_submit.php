<?php
// password_reset_submit.php

// データベース接続情報
$dsn = "mysql:host=183.90.241.215; dbname=semotion_weakness; charset=utf8";
$username = "semotion_weaknes";
$password = "94g02dji";

$message = ''; // 処理結果メッセージを格納する変数

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
        $token = $_POST['token'];
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword === $confirmPassword) {
            // トークンの有効性と有効期限を確認
            $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry > NOW()");
            $stmt->execute([$token]);
            $user = $stmt->fetch();

            if ($user) {
                // 新しいパスワードをハッシュ化して更新
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
                $result = $stmt->execute([$passwordHash, $token]);

                if ($result) {
                    $message = "パスワードの変更が成功しました。新しいパスワードでログインしてください。";
                } else {
                    $message = "パスワードの変更に失敗しました。";
                }
            } else {
                $message = "無効なトークン、またはトークンの有効期限が切れています。";
            }
        } else {
            $message = "パスワードが一致しません。";
        }
    }
} catch (PDOException $e) {
    $message = "データベース接続失敗: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>パスワード変更結果</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mt-5">
                <h2 class="mb-3 text-center">パスワード変更結果</h2>
                <div class="alert alert-info" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                <div class="text-center">
                    <?php if ($message === "パスワードが一致しません。"): ?>
                        <a href="password_reset.php?token=<?php echo htmlspecialchars($token); ?>" class="btn btn-primary">パスワードの再設定</a>
                    <?php elseif ($message === "無効なトークン、またはトークンの有効期限が切れています。"): ?>
                        <p>再度パスワードをリセットするために<br>登録済みのメールアドレスを入力してください。</p>
                        <a href="password_reset_form.php" class="btn btn-primary">再設定はこちらから</a>
                    <?php else: ?>
                        <a href="login_form.php" class="btn btn-primary">ログインページへ</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
