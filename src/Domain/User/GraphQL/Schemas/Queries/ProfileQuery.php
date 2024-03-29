<?php

declare(strict_types=1);

namespace Domain\User\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class ProfileQuery extends Query
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'me',
        'description' => 'User Profile',
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('User'));
    }

    public function resolve(
        mixed $root,
        array $args,
        User $context,
        ResolveInfo $resolveInfo,
        Closure $getSelectFields
    ): User {
        return User::me($getSelectFields());
    }
}
