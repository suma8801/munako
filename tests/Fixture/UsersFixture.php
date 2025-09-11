<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'email' => 'test@example.com',
                'name' => 'Test User',
                'yomi' => 'テストユーザー',
                'password' => '$2y$10$0123456789abcdefghijklmnopqrstuvwxyz', // hash of 'password123'
                'role_id' => 1,
                'plan_id' => 1,
                'course_id' => 1,
                'expire' => '2025-12-31 23:59:59',
                'token' => null,
                'token_expire' => null,
                'created' => '2025-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'email' => 'admin@example.com',
                'name' => 'Admin User',
                'yomi' => 'アドミンユーザー',
                'password' => '$2y$10$0123456789abcdefghijklmnopqrstuvwxyz', // hash of 'password123'
                'role_id' => 3,
                'plan_id' => 1,
                'course_id' => 1,
                'expire' => '2025-12-31 23:59:59',
                'token' => null,
                'token_expire' => null,
                'created' => '2025-01-01 00:00:00',
            ],
        ];
        parent::init();
    }
}
