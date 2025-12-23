<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReunionAttend Entity
 *
 * @property int $id
 * @property int $year
 * @property int $member_id
 * @property int $attend_status_id
 * @property string|null $note
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\AttendStatus $attend_status
 */
class ReunionAttend extends Entity
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
        'year' => true,
        'member_id' => true,
        'attend_status_id' => true,
        'note' => true,
        'created' => true,
        'modified' => true,
        'member' => true,
        'attend_status' => true,
    ];
}

