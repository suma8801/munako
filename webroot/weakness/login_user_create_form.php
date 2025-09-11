<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>ログインユーザ作成FORM</title>   
    <style>
        body {
            background-color: #f8f9fa; /* 背景色を薄いグレーに設定 */
        }
        .container {
            background-color: #fff; /* コンテナの背景色を白に設定 */
            padding: 20px; /* パディングを追加 */
            border-radius: 8px; /* 角を丸くする */
            box-shadow: 0 4px 6px rgba(0,0,0,.1); /* 影を追加 */
            max-width: 500px; /* 最大幅を500pxに設定 */
            margin-top: 40px; /* 上のマージンを設定 */
        }
        h1 {
            color: #333; /* 見出しの色を暗めのグレーに設定 */
            margin-bottom: 20px; /* 下のマージンを設定 */
        }
        .btn-primary {
            width: 100%; /* プライマリーボタンの幅を100%に設定 */
            margin-top: 20px; /* 上のマージンを設定 */
        }
        .btn-secondary {
            width: 100%; /* セカンダリーボタンの幅を100%に設定 */
            margin-top: 10px; /* 上のマージンを設定 */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">ログインユーザ作成</h1>
        <form action="login_user_create_exec.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">名前：</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス：</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード：</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">作成</button>
            <a href="login_home.php" class="btn btn-secondary">ホーム</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
