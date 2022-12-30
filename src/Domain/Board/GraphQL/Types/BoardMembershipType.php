<?php

declare(strict_types=1);

namespace Domain\Board\GraphQL\Types;

use Rebing\GraphQL\Support\EnumType;
use Domain\Board\Models\Relation;

class BoardMembershipType extends EnumType
{
    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'name' => 'BoardMembership',
        'description' => 'Board Membership Enum',
        'values' => [
            'OWNER' => [
                'value' => Relation::OWNER,
            ],
            'GUEST' => [
                'value' => Relation::GUEST,
            ],
        ],
    ];
}
