<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CoursesFixture
 */
class CoursesFixture extends TestFixture
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
                'name' => 'ベーシック',
                'created' => '2025-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'name' => 'マスター',
                'created' => '2025-01-01 00:00:00',
            ],
        ];
        parent::init();
    }
}
