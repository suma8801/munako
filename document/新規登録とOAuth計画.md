## 計画: ホームページの新規登録とOAuth対応

**概要**: ホームページの「新規登録」リンクをスタッフ/管理者のみ表示するように変更し、`homes/index`ページでOAuthログインオプションを実装します。

---

### **手順**

#### フェーズ 1: 「新規登録」のロールベース表示
1. **レイアウトロジックの更新**:
   - [templates/layout/default.php](templates/layout/default.php) を修正し、セッション内の`role_id`に基づいて「新規登録」リンクを条件付きで表示。
   - `AppController`の`getEffectiveRoleId()`を使用してロールを判定。

2. **コントローラーロジックの調整**:
   - [UsersController.php](src/Controller/UsersController.php)の`register()`メソッドで、`role_id`が2以上（スタッフ/管理者）の場合のみアクセスを許可。

3. **UIフィードバック**:
   - `/users/register`への不正アクセス試行時にフラッシュメッセージを追加。

---

#### フェーズ 2: `homes/index`のOAuth対応
1. **OAuthプラグインのインストール**（実施済み）:
   - 基底: [`league/oauth2-client`](https://packagist.org/packages/league/oauth2-client)
   - Google: [`league/oauth2-google`](https://packagist.org/packages/league/oauth2-google)
   - Apple: [`patrickbussmann/oauth2-apple`](https://packagist.org/packages/patrickbussmann/oauth2-apple)（`League\OAuth2\Client\Provider\Apple`）
   - LINE: [`gn-office/oauth2-line`](https://packagist.org/packages/gn-office/oauth2-line)
   - X（Twitter）: [`aporat/oauth2-xtwitter`](https://packagist.org/packages/aporat/oauth2-xtwitter)
   - Docker 利用時: `docker compose run --rm composer install` で `composer.lock` と同期。

2. **OAuthプロバイダーの設定**:
   - [config/app_local.example.php](config/app_local.example.php) に `OAuth` キー（Google / Apple / X / LINE）を追加済み。ローカルは [config/app_local.php](config/app_local.php) に同様のブロックを置き、値は環境変数（`OAUTH_*`）で渡す。
   - Apple は `clientId` に加え `teamId`・`keyFileId`・`keyFilePath`（`.p8` の絶対パス）が必要（Sign in with Apple）。
   - 変数名の一覧は `config/.env.example` の OAuth セクション（コメント）を参照。

3. **OAuthコントローラーの作成**:
   - OAuthフローを処理する`OAuthController`を追加。
   - メソッド:
     - `login($provider)` → プロバイダーの認証ページにリダイレクト。
     - `callback($provider)` → プロバイダーのレスポンスを処理し、ユーザーを認証。

4. **`homes/index`テンプレートの更新**:
   - 未認証ユーザー向けに「新規登録」リンクをOAuthログインボタンに置き換え。
   - プロバイダーのロゴ/アイコンを使用してUXを向上。

5. **OAuthフローのテスト**:
   - 各プロバイダーのログイン機能を検証。
   - ログイン失敗時のエラーハンドリングを確認。

---

#### フェーズ 3: 検証とクリーンアップ
1. **テスト**:
   - すべてのユーザーロールで「新規登録」の表示ロジックをテスト。
   - 各プロバイダーのOAuthログインフローをテスト。
   - ログイン後のリダイレクトロジックを確認。

2. **ドキュメント作成**:
   - OAuthプロバイダーの設定手順を[README.md](README.md)に追記。
   - メンテナンス性向上のためコードにコメントを追加。

3. **デプロイ**:
   - 変更をステージング環境にデプロイ。
   - ログを監視して問題を特定。

---

### **関連ファイル**
- [templates/layout/default.php](templates/layout/default.php) — 「新規登録」の表示ロジックを更新。
- [src/Controller/UsersController.php](src/Controller/UsersController.php) — `register()`のアクセス制御を調整。
- [src/Controller/AppController.php](src/Controller/AppController.php) — ロールチェックに`getEffectiveRoleId()`を使用。
- [src/Controller/OAuthController.php](src/Controller/OAuthController.php) — OAuthフロー用の新しいコントローラー。
- [templates/Homes/index.php](templates/Homes/index.php) — OAuthログインボタンを追加。
- [config/app_local.php](config/app_local.php) — OAuthプロバイダーの設定を追加。

---

### **検証**
1. **ロールベース表示**:
   - 一般ユーザー、スタッフ、管理者としてログインし、「新規登録」の表示を確認。
   - `/users/register`への不正アクセスを試行。

2. **OAuthログイン**:
   - Google、Apple、X、LINEのログインフローをテスト。
   - ユーザーセッションの作成とリダイレクトを確認。

3. **リグレッションテスト**:
   - 既存のログインおよび登録フローが影響を受けていないことを確認。

---

### **決定事項**
- **OAuthプロバイダー**: ユーザーリクエストに基づき、Google、Apple、X、LINEを選定。
- **ロールベースアクセス**: セキュリティのため、スタッフ/管理者のみ「新規登録」を表示。

---

### **users テーブル（フェーズ２向けスキーマ）**
- `docker/mysql/init/01_users.sql` に以下を反映済み。
  - `password` … NULL 許可（OAuth 専用ユーザーはパスワードなし）
  - `oauth_provider` … `varchar(32)` NULL（例: `google`, `line`, `apple`, `x`）
  - `oauth_subject` … `varchar(255)` NULL（プロバイダー側の一意 ID）
  - 複合 UNIQUE `users_oauth_provider_subject`（`oauth_provider` + `oauth_subject`）
- CakePHP: `User` エンティティ・`UsersTable`（バリデーション・ルール・`findAuth` 選択列）を同期。

**既存 DB をボリュームで継続している場合**（新規 `01_users.sql` が再実行されないとき）は、手動で例えば次を実行する。

```sql
ALTER TABLE `users`
  MODIFY `password` varchar(255) NULL COMMENT 'パスワードのハッシュ値（NULLはOAuth専用ユーザー）',
  ADD COLUMN `oauth_provider` varchar(32) NULL COMMENT 'OAuthプロバイダー識別子' AFTER `password`,
  ADD COLUMN `oauth_subject` varchar(255) NULL COMMENT 'プロバイダー発行のユーザー一意ID' AFTER `oauth_provider`,
  ADD UNIQUE KEY `users_oauth_provider_subject` (`oauth_provider`, `oauth_subject`);
```

### **追加検討事項**
1. **OAuthユーザーマッピング**:
   - OAuthユーザーを既存ロールにどのようにマッピングするかを決定（例: デフォルトで一般ユーザー）。
2. **セッション有効期限**:
   - セキュリティ向上のためセッションタイムアウトを実装。
3. **モバイル対応**:
   - OAuthボタンがモバイルフレンドリーであることを確認。