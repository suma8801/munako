# Windows 環境での開発環境セットアップ手順

## ✅ 前提条件
- [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop/) をインストール済み
- [Git](https://git-scm.com/download/win) をインストール済み
- WSL2 が有効化されていること（推奨）
- ローカルPCにてMySQLが起動している場合は、ストップするか、docker-compose.yml 中のポート番号を変更する

---

## 1. リポジトリを取得
```bash
git clone https://github.com/あなたのユーザー名/witch.git
cd munako
```

## 2. 環境変数の設定

(以下のコマンドは、Windowsでは、init.bat を実行する)

dockerのために `.env` ファイルを作成します。

```bash
cp .env.example .env
```

`.env` ファイルの内容を確認し、必要に応じて値を変更してください：

**注意**: `.env` ファイルには機密情報が含まれているため、Gitにコミットされません。


cakePHPプロジェクトのconfigディレクトリに `.env` ファイルを作成し、データベース設定を記述します。

```bash
cd config
cp .env.example .env
cp app_local.example.php app_local.php
cd ..
```
それぞれのファイルの内容を確認し、必要に応じて値を変更してください：

**注意**: これらのファイルには機密情報が含まれているため、Gitにコミットされません。


## 3.依存パッケージのインストール

CakePHP の依存パッケージを Docker 上でインストールします。
```bash
docker compose run --rm app composer install
```
(初回のみ実行)

## 4.コンテナの起動
```bash
docker compose up -d
```

- CakePHP → http://localhost:8080
- phpMyAdmin → http://localhost:8081

## 5.docker-compose コマンドあれこれ

### コンテナを起動
```bash
docker compose up -d
```

### コンテナを停止して削除
```bash
docker compose down
```

### 起動中のコンテナを確認
```bash
docker compose ps
```

### コンテナのログをリアルタイム表示
```bash
docker compose logs -f
```

### app コンテナにログイン
```bash
docker compose exec app bash
```

### docker ボリューム（データベースのデータ）を削除
```bash
docker volume rm witch_db_data
```

### docker データベースを削除して停止
```bash
docker compose down -v
```

### docker 起動時のDBログをみる
```bash
docker logs cakephp-db
```

