<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DestinyResult Entity
 *
 * @property int $id
 * @property string|null $card_title
 * @property string|null $etitle
 * @property string|null $card_image
 * @property string|null $short_text
 * @property string|null $long_text
 */
class DestinyResult extends Entity
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
        'card_title' => true,
        'etitle' => true,
        'card_image' => true,
        'short_text' => true,
        'long_text' => true,
    ];
}
