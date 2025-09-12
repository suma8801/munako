<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $yomi
 * @property string $password
 * @property int $role_id
 * @property string|null $token
 * @property \Cake\I18n\DateTime|null $token_expire
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Role $role
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
        'token',
    ];
}
