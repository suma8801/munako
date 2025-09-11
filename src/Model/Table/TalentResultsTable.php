<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TalentResults Model
 *
 * @method \App\Model\Entity\TalentResult newEmptyEntity()
 * @method \App\Model\Entity\TalentResult newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TalentResult> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TalentResult get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TalentResult findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TalentResult patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TalentResult> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TalentResult|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TalentResult saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TalentResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TalentResult>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TalentResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TalentResult> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TalentResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TalentResult>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TalentResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TalentResult> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TalentResultsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('talent_results');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('card_title')
            ->maxLength('card_title', 255)
            ->allowEmptyString('card_title');

        $validator
            ->scalar('etitle')
            ->maxLength('etitle', 255)
            ->allowEmptyString('etitle');

        $validator
            ->scalar('card_image')
            ->maxLength('card_image', 255)
            ->allowEmptyFile('card_image');

        $validator
            ->scalar('short_text')
            ->allowEmptyString('short_text');

        $validator
            ->scalar('long_text')
            ->allowEmptyString('long_text');

        return $validator;
    }
}
