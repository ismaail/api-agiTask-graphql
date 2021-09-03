<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class UserQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 */
class UsersQuery extends Query
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'users',
        'description' => 'List of Users',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return GraphQL::paginate(GraphQL::type('User'));
    }

    /**
     * @return array
     */
    public function args(): array
    {
        return [
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
            ],
        ];
    }

    /**
     * @param $root
     * @param array $args
     * @param $context
     * @param \GraphQL\Type\Definition\ResolveInfo $info
     * @param \Closure $getSelectFields
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, array $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $perPage = $args['limit'] ?? config('agitask.pagination.per_page');
        $page = $args['page'] ?? 1;

        return User
            ::with($fields->getRelations())
            ->select($fields->getSelect())
            ->paginate($perPage, page: $page);
    }
}
