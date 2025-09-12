<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MembersFixture
 */
class MembersFixture extends TestFixture
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
                'class' => 1,
                'no' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'yomi' => 'Lorem ipsum dolor sit amet',
                'gone' => 1,
            ],
        ];
        parent::init();
    }
}
