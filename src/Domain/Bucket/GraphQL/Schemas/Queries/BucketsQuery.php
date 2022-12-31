<?php

declare(strict_types=1);

namespace Domain\Bucket\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
use Domain\Bucket\Models\Bucket;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Support\GraphQL\Traits\PipeFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;
use Domain\Bucket\DataTransferObjects\BucketsQueryArgsData;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class BucketsQuery extends Query
{
    use PipeFilter;

    /**
     * @var array<string, string>
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
     * @return array<string, array<string, \GraphQL\Type\Definition\ScalarType>>
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
     * @param mixed $root
     * @param array $args
     * @param \Domain\User\Models\User $context
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo
     * @param \Closure $getSelectFields
     *
     * @return \Illuminate\Database\Eloquent\Collection<int,\Domain\Bucket\Models\Bucket>
     */
    public function resolve(
        mixed $root,
        array $args,
        User $context,
        ResolveInfo $resolveInfo,
        Closure $getSelectFields
    ): Collection {
        return Bucket::findAll($getSelectFields(), BucketsQueryArgsData::fromArray($args));
    }
}
