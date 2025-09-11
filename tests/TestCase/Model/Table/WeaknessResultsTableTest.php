<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WeaknessResultsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WeaknessResultsTable Test Case
 */
class WeaknessResultsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\WeaknessResultsTable
     */
    protected $WeaknessResults;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.WeaknessResults',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('WeaknessResults') ? [] : ['className' => WeaknessResultsTable::class];
        $this->WeaknessResults = $this->getTableLocator()->get('WeaknessResults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->WeaknessResults);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\WeaknessResultsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
