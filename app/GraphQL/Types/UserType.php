<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
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
     * @var array
     */
    protected $attributes = [
        'name' => 'User',
        'model' => User::class,
    ];

    /**
     * @return array[]
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
        ];
    }
}
