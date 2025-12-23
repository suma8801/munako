<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property int $class
 * @property int $no
 * @property string $name
 * @property string $yomi
 * @property int|null $gone
 *
 * @property \Cake\ORM\ResultSet<\App\Model\Entity\ReunionAttend>|\App\Model\Entity\ReunionAttend[] $reunion_attends
 */
class Member extends Entity
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
        'class' => true,
        'no' => true,
        'name' => true,
        'yomi' => true,
        'gone' => true,
        'reunion_attends' => true,
    ];
}
