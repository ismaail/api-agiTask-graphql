<?php

declare(strict_types=1);

namespace App\GraphQL\Schemas\Default\Queries;

use Closure;
use App\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Traits\PipeFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class BoardsQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class BoardsQuery extends Query
{
    use PipeFilter;

    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'boards',
        'description' => 'List all Boards with pagination'
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return GraphQL::paginate(GraphQL::type('Board'));
    }

    /**
     * @return array[]
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

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo
     * @param \Closure $getSelectFields
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
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
