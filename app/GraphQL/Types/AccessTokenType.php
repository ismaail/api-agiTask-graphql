<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Class AccessToken
 */
class AccessTokenType extends GraphQLType
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'AccessToken',
    ];

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'token_type' => [
                'type' => Type::nonNull(Type::string()),
                'selectable' => false,
            ],
            'access_token' => [
                'type' => Type::nonNull(Type::string()),
                'selectable' => false,
            ],
            'expires_in' => [
                'type' => Type::nonNull(Type::int()),
                'selectable' => false,
                'description' => 'Token Expires in Seconds',
            ],
        ];
    }
}
