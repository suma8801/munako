<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TalentResultsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TalentResultsTable Test Case
 */
class TalentResultsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TalentResultsTable
     */
    protected $TalentResults;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TalentResults',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TalentResults') ? [] : ['className' => TalentResultsTable::class];
        $this->TalentResults = $this->getTableLocator()->get('TalentResults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TalentResults);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TalentResultsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
