<?php

declare(strict_types=1);

namespace Domain\Board\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
use Domain\Board\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Support\GraphQL\Traits\PipeFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @phpcs:disable Generic.Files.LineLength.TooLong
 */
class BoardsQuery extends Query
{
    use PipeFilter;

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

    public function resolve(mixed $root, array $args, User $context, ResolveInfo $resolveInfo, Closure $getSelectFields): LengthAwarePaginator
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $query = Board
            ::with($with)
            ->select($select);

        $this->filter($query, 'archived', $args);

        return $query->paginate($args['limit'], page: $args['page']);
    }
}
