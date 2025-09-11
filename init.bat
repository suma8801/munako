@echo off
REM 初期化スクリプト for Windows
REM このファイルは、Gitリポジトリをpullした後に実行してください

echo.
echo ========================================
echo 初期化スクリプトを開始します...
echo ========================================
echo.

REM プロジェクトルートの.envファイルを作成
echo プロジェクトルートの.envファイルを作成中...
if exist .env.example (
    copy .env.example .env
    echo ✓ .envファイルを作成しました
) else (
    echo ✗ .env.exampleファイルが見つかりません
)

REM configディレクトリに移動
echo.
echo configディレクトリの設定ファイルを作成中...
cd config

REM config/.envファイルを作成
if exist .env.example (
    copy .env.example .env
    echo ✓ config/.envファイルを作成しました
) else (
    echo ✗ config/.env.exampleファイルが見つかりません
)

REM app_local.phpファイルを作成
if exist app_local.example.php (
    copy app_local.example.php app_local.php
    echo ✓ app_local.phpファイルを作成しました
) else (
    echo ✗ app_local.example.phpファイルが見つかりません
)

REM プロジェクトルートに戻る
cd ..

echo.
echo ========================================
echo 初期化が完了しました！
echo ========================================
echo.
echo 次のコマンドでDockerコンテナを作成し起動してください：
echo docker compose run --rm app composer install
echo docker compose up -d
echo.
echo アプリケーションは以下のURLでアクセスできます：
echo - CakePHP: http://localhost:8080
echo - phpMyAdmin: http://localhost:8081
echo.
pause 