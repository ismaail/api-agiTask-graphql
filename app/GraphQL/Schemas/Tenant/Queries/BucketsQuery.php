<?php

declare(strict_types=1);

namespace App\GraphQL\Schemas\Tenant\Queries;

use Closure;
use App\Models\User;
use Domain\Bucket\Models\Bucket;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\GraphQL\Traits\PipeFilter;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BucketQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @phpcs:disable Generic.Files.LineLength.TooLong
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
     * @param \App\Models\User $context
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo
     * @param \Closure $getSelectFields
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \Domain\Bucket\Models\Bucket>
     */
    public function resolve(mixed $root, array $args, User $context, ResolveInfo $resolveInfo, Closure $getSelectFields): Collection
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $query = Bucket
            ::with($with)
            ->select($select);

        $this->filter($query, name: 'archived', args: $args);

        return $query->get();
    }
}
