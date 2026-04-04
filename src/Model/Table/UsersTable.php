<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /** 一般ユーザー（メール新規登録 registerUser 用） */
    public const ROLE_ID_GENERAL = 1;

    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('yomi')
            ->maxLength('yomi', 255)
            ->requirePresence('yomi', 'create')
            ->notEmptyString('yomi');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->scalar('oauth_provider')
            ->maxLength('oauth_provider', 32)
            ->allowEmptyString('oauth_provider');

        $validator
            ->scalar('oauth_subject')
            ->maxLength('oauth_subject', 255)
            ->allowEmptyString('oauth_subject');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->allowEmptyString('token');

        $validator
            ->dateTime('token_expire')
            ->allowEmptyDateTime('token_expire');

        return $validator;
    }

    /**
     * /users/register-user フォーム送信時（メール・パスワードのみ）
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRegisterUserInput(Validator $validator): Validator
    {
        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        return $validator;
    }

    /**
     * メールによる一般ユーザー新規登録の保存直前（name/yomi/role 込み）
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRegisterUser(Validator $validator): Validator
    {
        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('yomi')
            ->maxLength('yomi', 255)
            ->requirePresence('yomi', 'create')
            ->notEmptyString('yomi');

        $validator
            ->integer('role_id')
            ->requirePresence('role_id', 'create')
            ->notEmptyString('role_id');

        $validator
            ->scalar('oauth_provider')
            ->maxLength('oauth_provider', 32)
            ->allowEmptyString('oauth_provider');

        $validator
            ->scalar('oauth_subject')
            ->maxLength('oauth_subject', 255)
            ->allowEmptyString('oauth_subject');

        return $validator;
    }

    /**
     * メール新規登録で name / yomi が空のとき、メールローカル部またはプレースホルダで埋める
     *
     * @param \App\Model\Entity\User $user User entity
     * @return void
     */
    public function applyRegisterUserDisplayDefaults(\App\Model\Entity\User $user): void
    {
        $email = (string)$user->get('email');
        $local = '';
        if ($email !== '' && str_contains($email, '@')) {
            $at = mb_strpos($email, '@');
            if ($at !== false) {
                $local = mb_substr($email, 0, $at);
            }
        }
        $local = $local !== '' ? mb_substr($local, 0, 255) : '';

        $name = $user->get('name');
        if ($name === null || $name === '') {
            $user->set('name', $local !== '' ? $local : __('ユーザー'));
        } else {
            $user->set('name', mb_substr((string)$name, 0, 255));
        }

        $yomi = $user->get('yomi');
        if ($yomi === null || $yomi === '') {
            $user->set('yomi', $local !== '' ? $local : __('ゆーざー'));
        } else {
            $user->set('yomi', mb_substr((string)$yomi, 0, 255));
        }
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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        $rules->add(function ($entity, $options) {
            $provider = $entity->get('oauth_provider');
            $subject = $entity->get('oauth_subject');
            if ($provider === null || $provider === '' || $subject === null || $subject === '') {
                return true;
            }
            $query = $this->find()
                ->where([
                    'oauth_provider' => $provider,
                    'oauth_subject' => $subject,
                ]);
            if (!$entity->isNew() && $entity->get('id')) {
                $query->where(['id !=' => $entity->get('id')]);
            }
            return !$query->count();
        }, 'oauthUnique', [
            'errorField' => 'oauth_subject',
            'message' => 'このOAuthアカウントは既に登録されています。',
        ]);

        $rules->add(function ($entity, $options) {
            $hasOAuth = !empty($entity->get('oauth_provider')) && !empty($entity->get('oauth_subject'));
            if ($hasOAuth) {
                return true;
            }
            if (!$entity->isNew()) {
                return true;
            }
            $password = $entity->get('password');
            return $password !== null && $password !== '';
        }, 'passwordOrOauth', [
            'errorField' => 'password',
            'message' => 'パスワードを入力するか、OAuthで登録してください。',
        ]);

        return $rules;
    }

    /**
     * 認証用のfinderメソッド
     *
     * @param \Cake\ORM\Query $query クエリオブジェクト
     * @param array $options オプション
     * @return \Cake\ORM\Query
     */
    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        $query
            ->select([
                'id', 'email', 'name', 'yomi', 'password',
                'oauth_provider', 'oauth_subject',
                'role_id', 'token', 'token_expire', 'created',
            ])
            ->where(['Users.email' => $options['username']]);

        return $query;
    }

    /**
     * パスワードを検証する
     *
     * @param string $password 検証するパスワード
     * @param string $hashedPassword ハッシュ化されたパスワード
     * @return bool パスワードが正しい場合true
     */
    public function verifyPassword(string $password, ?string $hashedPassword): bool
    {
        if ($hashedPassword === null || $hashedPassword === '') {
            return false;
        }
        $hasher = new DefaultPasswordHasher();
        return $hasher->check($password, $hashedPassword);
    }
}
