<?php

declare(strict_types=1);

namespace Domain\Board\GraphQL\Types;

use Rebing\GraphQL\Support\EnumType;
use Domain\Board\Models\BoardMemberRelation;

/**
 * Class BoardMembership
 * @package App\GraphQL\Enums
 */
class BoardMembershipType extends EnumType
{
    /**
     * @var array<string, string|array>
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
