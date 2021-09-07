<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class BoardQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 */
class BoardQuery extends Query
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'board',
        'description' => 'Find single Board by ID.',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return GraphQL::type('Board');
    }

    /**
     * @return array[]
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
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
     * @return \App\Models\Board|null
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): ?Board
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Board
            ::where('id', $args['id'])
            ->with($with)
            ->select($select)
            ->first();
    }
}
