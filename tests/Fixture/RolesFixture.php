<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RolesFixture
 */
class RolesFixture extends TestFixture
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
                'name' => '一般',
                'created' => '2025-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'name' => 'オペレータ',
                'created' => '2025-01-01 00:00:00',
            ],
            [
                'id' => 3,
                'name' => '管理者',
                'created' => '2025-01-01 00:00:00',
            ],
        ];
        parent::init();
    }
}
