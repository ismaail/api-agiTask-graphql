<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\Bucket;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class BucketQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class BucketsQuery extends Query
{
    use PipeFilter;

    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'buckets',
        'description' => "List all Boars's Buckets",
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Bucket'));
    }

    /**
     * @return array[]
     */
    public function args(): array
    {
        return [
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
     * @return \App\Models\Bucket[]|\Illuminate\Database\Eloquent\Collection
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $query = Bucket
            ::with($with)
            ->select($select);

        $this->filter($query, 'archived', $args);

        return $query->get();
    }
}
