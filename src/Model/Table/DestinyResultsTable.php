<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DestinyResults Model
 *
 * @method \App\Model\Entity\DestinyResult newEmptyEntity()
 * @method \App\Model\Entity\DestinyResult newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DestinyResult> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DestinyResult get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DestinyResult findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DestinyResult patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DestinyResult> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DestinyResult|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DestinyResult saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DestinyResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DestinyResult>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DestinyResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DestinyResult> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DestinyResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DestinyResult>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DestinyResult>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DestinyResult> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DestinyResultsTable extends Table
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

        $this->setTable('destiny_results');
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
