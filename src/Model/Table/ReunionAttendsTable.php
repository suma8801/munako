<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReunionAttends Model
 *
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\AttendStatusesTable&\Cake\ORM\Association\BelongsTo $AttendStatuses
 *
 * @method \App\Model\Entity\ReunionAttend newEmptyEntity()
 * @method \App\Model\Entity\ReunionAttend newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ReunionAttend> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReunionAttend get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ReunionAttend findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ReunionAttend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ReunionAttend> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReunionAttend|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ReunionAttend saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ReunionAttend>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ReunionAttend>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ReunionAttend>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ReunionAttend> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ReunionAttend>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ReunionAttend>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ReunionAttend>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ReunionAttend> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReunionAttendsTable extends Table
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

        $this->setTable('reunion_attends');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('AttendStatuses', [
            'foreignKey' => 'attend_status_id',
            'joinType' => 'INNER',
        ]);
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
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmptyString('year');

        $validator
            ->integer('member_id')
            ->requirePresence('member_id', 'create')
            ->notEmptyString('member_id');

        $validator
            ->integer('attend_status_id')
            ->requirePresence('attend_status_id', 'create')
            ->notEmptyString('attend_status_id');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['member_id'], 'Members'), ['errorField' => 'member_id']);
        $rules->add($rules->existsIn(['attend_status_id'], 'AttendStatuses'), ['errorField' => 'attend_status_id']);

        return $rules;
    }
}

