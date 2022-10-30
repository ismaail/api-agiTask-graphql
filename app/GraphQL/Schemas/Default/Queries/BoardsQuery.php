<?php

declare(strict_types=1);

namespace App\GraphQL\Schemas\Default\Queries;

use Closure;
use App\Models\User;
use App\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Traits\PipeFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BoardsQuery
 * @package App\GraphQL\Queries
 *
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
     * @return array<string, array<string, \GraphQL\Type\Definition\ScalarType>>
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
