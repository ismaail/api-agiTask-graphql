<?php

declare(strict_types=1);

namespace App\GraphQL\Enums;

use App\Models\BoardMember;
use Rebing\GraphQL\Support\EnumType;

/**
 * Class BoardMembership
 * @package App\GraphQL\Enums
 */
class BoardMembership extends EnumType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'BoardMembership',
        'description' => 'Board Membership Enum',
        'values' => [
            'OWNER' => [
                'value' => BoardMember::RELATION_OWNER,
            ],
            'GUEST' => [
                'value' => BoardMember::RELATION_GUEST,
            ],
        ],
    ];
}
