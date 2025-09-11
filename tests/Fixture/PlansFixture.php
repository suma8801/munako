<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlansFixture
 */
class PlansFixture extends TestFixture
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
                'name' => '無料',
                'created' => '2025-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'name' => 'ライト',
                'created' => '2025-01-01 00:00:00',
            ],
            [
                'id' => 3,
                'name' => 'アドバンス',
                'created' => '2025-01-01 00:00:00',
            ],
        ];
        parent::init();
    }
}
