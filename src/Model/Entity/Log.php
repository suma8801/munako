<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Log Entity（メモ追記ログ）
 *
 * @property int $id
 * @property int $member_id
 * @property int $year
 * @property int|null $user_id
 * @property string $user_name
 * @property string $body
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\User|null $user
 */
class Log extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'member_id' => true,
        'year' => true,
        'user_id' => true,
        'user_name' => true,
        'body' => true,
        'created' => true,
        'member' => true,
        'user' => true,
    ];
}
