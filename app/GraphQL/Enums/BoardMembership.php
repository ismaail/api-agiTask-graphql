<?php

declare(strict_types=1);

namespace App\GraphQL\Enums;

use App\Models\BoardMemberRelation;
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
                'value' => BoardMemberRelation::OWNER,
            ],
            'GUEST' => [
                'value' => BoardMemberRelation::GUEST,
            ],
        ],
    ];
}
