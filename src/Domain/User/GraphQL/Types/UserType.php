<?php

declare(strict_types=1);

namespace Domain\User\GraphQL\Types;

use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphqlType;

/**
 * Class UserType
 * @package App\GraphQL\Types
 */
class UserType extends GraphqlType
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'User',
        'model' => User::class,
    ];

    /**
     * @return array<string, array<string, mixed>>
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'username' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'boards' => [
                'type' => Type::listOf(GraphQL::type('Board')),
            ],
            'membership' => [
                'type' => GraphQL::type('BoardMembership'),
                'selectable' => false,
                'resolve' => fn(User $u) => object_get($u, 'membership.relation'), // 'membership' as pivot
            ],
        ];
    }
}
