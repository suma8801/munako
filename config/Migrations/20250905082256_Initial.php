<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Initial extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        // roles テーブル
        $table = $this->table('roles', ['engine' => 'InnoDB']);
        $table->addColumn('name', 'string', ['limit' => 100, 'comment' => '役割名(一般、オペレータ、管理者)'])
              ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();

        // plans テーブル
        $table = $this->table('plans', ['engine' => 'InnoDB']);
        $table->addColumn('name', 'string', ['limit' => 50, 'comment' => 'プラン名（無料、ライト、アドバンス）'])
              ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();

        // courses テーブル
        $table = $this->table('courses', ['engine' => 'InnoDB']);
        $table->addColumn('name', 'string', ['limit' => 50, 'comment' => 'コース名（ベーシック、マスター）'])
              ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();

        // users テーブル
        $table = $this->table('users', ['engine' => 'InnoDB']);
        $table->addColumn('email', 'string', ['limit' => 255, 'comment' => 'ログイン名（mail)'])
              ->addColumn('name', 'string', ['limit' => 255, 'comment' => '名前'])
              ->addColumn('yomi', 'string', ['limit' => 255, 'comment' => 'よみがな'])
              ->addColumn('password', 'string', ['limit' => 255, 'comment' => 'パスワードのハッシュ値'])
              ->addColumn('role_id', 'integer', ['comment' => 'ロールテーブルのid'])
              ->addColumn('plan_id', 'integer', ['comment' => '課金タイプ'])
              ->addColumn('course_id', 'integer', ['comment' => '受講コース'])
              ->addColumn('expire', 'datetime', ['comment' => 'ユーザーの期限'])
              ->addColumn('token', 'string', ['limit' => 255, 'null' => true, 'comment' => 'パスワード忘れのトークン'])
              ->addColumn('token_expire', 'datetime', ['null' => true, 'comment' => 'トークンの期限'])
              ->addColumn('created', 'datetime', ['comment' => 'ユーザーの利用開始'])
              ->create();
    }
}
