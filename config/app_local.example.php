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
];
