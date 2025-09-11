<!-- <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>ログインページ</h1>
    <form action="login_exec.php" method="post">
        <div>
            <label>
                email：
                <input type="email" name="email" required>
            </label>
        </div>
        <div>
            <label>
                password：
                <input type="password" name="password" required>
            </label>
        </div>
        
        <input type="submit" value="ログイン">
        <br>
        <a href="login_home.php">ホーム</a>
        <a href="login_user_create_form.php">新規登録</a>
    </form>
</body>
</html> -->


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Login Page</title>
    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 100%; /* 全デバイスで最大幅を100%に設定 */
            padding: 15px; /* パディングを追加 */
            margin: 20px auto; /* 上下のマージンを調整 */
            background-color: #fff;
        }

        @media (min-width: 768px) {
            .login-container {
                max-width: 400px; /* 中・大型デバイスでは最大幅を400pxに設定 */
                margin: 50px auto; /* 中・大型デバイスではマージンを大きく */
            }
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #495057;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border: 1px solid #0056b3;
        }

        .forgot-password,
        .new-user {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }

        .forgot-password a,
        .new-user a {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password a:hover,
        .new-user a:hover {
            text-decoration: underline;
        }
        html, body {
        overflow: hidden; /* スクロールバーを無効にする */
        height: 100%; /* 必要に応じて設定 */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-container">
        <img src="https://semotion.xsrv.jp/weakness/image/loginimage.png" width="100%">
        <form action="login_exec.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">ログイン</button>
        </form>

        <div class="forgot-password">
            <a href="https://semotion.xsrv.jp/weakness/password_reset_form.php">ログイン情報を忘れた方はこちら</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</body>
</html>
