<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $yomi
 * @property string $password
 * @property int $role_id
 * @property int $plan_id
 * @property int $course_id
 * @property \Cake\I18n\DateTime $expire
 * @property string $token
 * @property \Cake\I18n\DateTime $token_expire
 * @property \Cake\I18n\DateTime $created
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'email' => true,
        'name' => true,
        'yomi' => true,
        'password' => true,
        'role_id' => true,
        'plan_id' => true,
        'course_id' => true,
        'expire' => true,
        'token' => true,
        'token_expire' => true,
        'created' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * パスワードのハッシュ化
     *
     * @param string $password 平文パスワード
     * @return string|null ハッシュ済みパスワード
     */
    protected function _setPassword(string $password): ?string
    {
        if ($password === '') {
            return null;
        }

        return (new DefaultPasswordHasher())->hash($password);
    }
}
