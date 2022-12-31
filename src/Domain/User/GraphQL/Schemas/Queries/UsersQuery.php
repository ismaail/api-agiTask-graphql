<?php

declare(strict_types=1);

namespace Domain\User\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Pagination\LengthAwarePaginator;
use Domain\User\DataTransferObjects\UsersQueryArgsData;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 */
class UsersQuery extends Query
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'users',
        'description' => 'List of Users',
    ];

    public function type(): Type
    {
        return GraphQL::paginate(GraphQL::type('User'));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'defaultValue' => config('agitask.pagination.per_page'),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
                'defaultValue' => 1,
            ],
        ];
    }

    public function resolve(
        mixed $root,
        array $args,
        User $context,
        ResolveInfo $info,
        Closure $getSelectFields
    ): LengthAwarePaginator {
        return User::findPaginate($getSelectFields(), UsersQueryArgsData::fromArray($args));
    }
}
