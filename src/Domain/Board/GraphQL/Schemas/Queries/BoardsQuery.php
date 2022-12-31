<?php

declare(strict_types=1);

namespace Domain\Board\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
use Domain\Board\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Pagination\LengthAwarePaginator;
use Domain\Board\DataTransferObjects\BoardsQueryArgsData;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class BoardsQuery extends Query
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'boards',
        'description' => 'List all Boards with pagination'
    ];

    public function type(): Type
    {
        return GraphQL::paginate(GraphQL::type('Board'));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'defaultValue' => config('agitask.pagination.per_page'),
            ],
            'page' => [
                'type' => Type::int(),
                'defaultValue' => 1,
            ],
            'archived' => [
                'type' => Type::boolean(),
            ],
        ];
    }

    public function resolve(
        mixed $root,
        array $args,
        User $context,
        ResolveInfo $resolveInfo,
        Closure $getSelectFields
    ): LengthAwarePaginator {
        return Board::findPaginate(
            fields: $getSelectFields(),
            args: BoardsQueryArgsData::fromArray($args),
        );
    }
}
