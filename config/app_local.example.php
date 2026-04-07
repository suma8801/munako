<?php
/*
 * app.php 設定を上書きするためのローカル設定ファイルです。
 * このファイルを app_local.php としてコピーし、必要に応じて変更してください。
 * 注意: app_local.php のような認証情報を含むファイルはバージョン管理にコミットしないでください。
 */
return [
    /*
     * デバッグレベル:
     *
     * 本番モード:
     * false: エラーメッセージや警告は表示されません。
     *
     * 開発モード:
     * true: エラーや警告が表示されます。
     */
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    /* 日本で使うサーバなので設定　 */
    'App' => [
        'timezone' => 'Asia/Tokyo',
        'defaultLocale' => env('APP_DEFAULT_LOCALE', 'ja_JP'),
        'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'Asia/Tokyo'),
        // 本番で固定したいとき（リバースプロキシ配下やメール内の絶対URL用）。未設定時はリクエストから自動判定
        'fullBaseUrl' => env('APP_FULL_BASE_URL') ?: false,
    ],

    /*
     * セキュリティおよび暗号化の設定
     *
     * - salt - セキュリティハッシュメソッドで使用されるランダムな文字列。
     *   salt値は暗号化キーとしても使用されます。
     *   非常に機密性の高いデータとして扱ってください。
     * 
     * 本来はここで設定せずに .env ファイルで設定することが理想だが、
     * 共通化のためにここで設定している
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '3f9FtW05kLpkn22EiVhtp4wufW0QHWqg45KgB9G0bMK'),
    ],

    /*
     * アプリケーションのデータストアに接続するためのORM用接続情報。
     *
     * 詳細な設定オプションは app.php を参照してください。
     */
    'Datasources' => [
        'default' => [
            'host' => env('DB_HOST', 'localhost'),
            /*
             * CakePHPは選択されたドライバに基づいてデフォルトのDBポートを使用します。
             */
            'port' => env('DB_PORT', '3306'),
            'username' => env('DB_USERNAME', 'my_app'),
            'password' => env('DB_PASSWORD', 'secret'),
            'database' => env('DB_DATABASE', 'my_app'),
            /*
             * PostgreSQLドライバでデフォルトの 'public' スキーマ以外を使用する場合はここで設定してください。
             */
            //'schema' => 'myapp',

            /*
             * DSN文字列を使って全設定を指定することもできます。
             */
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * テストスイート実行時に使用されるテスト用接続です。
         */
        'test' => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'username' => env('DB_USERNAME', 'my_app'),
            'password' => env('DB_PASSWORD', 'secret'),
            'database' => env('DB_DATABASE', 'my_app'),
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    /*
     * メール設定
     *
     * SmtpTransportを使用する場合のホストや認証情報の設定
     *
     * 詳細な設定オプションは app.php を参照してください。
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],

    /*
     * OAuth 2.0（フェーズ２）
     *
     * 認証情報は .env / 環境変数で渡すこと。redirectUri は各プロバイダーのコンソールに登録した URL と完全一致させる。
     * DashedRoute では OAuthController の URL は /o-auth/callback/{google|facebook|x|line}（/oauth ではない）。
     * 使用パッケージ: league/oauth2-client, league/oauth2-google, league/oauth2-facebook,
     * gn-office/oauth2-line, aporat/oauth2-xtwitter
     */
    'OAuth' => [
        'Google' => [
            'enabled' => filter_var(env('OAUTH_GOOGLE_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
            'clientId' => env('OAUTH_GOOGLE_CLIENT_ID', ''),
            'clientSecret' => env('OAUTH_GOOGLE_CLIENT_SECRET', ''),
            'redirectUri' => env('OAUTH_GOOGLE_REDIRECT_URI', ''),
        ],
        'Facebook' => [
            'enabled' => filter_var(env('OAUTH_FACEBOOK_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
            'clientId' => env('OAUTH_FACEBOOK_CLIENT_ID', ''),
            'clientSecret' => env('OAUTH_FACEBOOK_CLIENT_SECRET', ''),
            'redirectUri' => env('OAUTH_FACEBOOK_REDIRECT_URI', ''),
            'graphApiVersion' => env('OAUTH_FACEBOOK_GRAPH_API_VERSION', 'v21.0'),
        ],
        'X' => [
            'enabled' => filter_var(env('OAUTH_X_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
            'clientId' => env('OAUTH_X_CLIENT_ID', ''),
            'clientSecret' => env('OAUTH_X_CLIENT_SECRET', ''),
            'redirectUri' => env('OAUTH_X_REDIRECT_URI', ''),
        ],
        'Line' => [
            'enabled' => filter_var(env('OAUTH_LINE_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
            'clientId' => env('OAUTH_LINE_CHANNEL_ID', ''),
            'clientSecret' => env('OAUTH_LINE_CHANNEL_SECRET', ''),
            'redirectUri' => env('OAUTH_LINE_REDIRECT_URI', ''),
        ],
    ],
];
