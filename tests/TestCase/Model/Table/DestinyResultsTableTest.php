<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DestinyResultsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DestinyResultsTable Test Case
 */
class DestinyResultsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DestinyResultsTable
     */
    protected $DestinyResults;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.DestinyResults',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DestinyResults') ? [] : ['className' => DestinyResultsTable::class];
        $this->DestinyResults = $this->getTableLocator()->get('DestinyResults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DestinyResults);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\DestinyResultsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
