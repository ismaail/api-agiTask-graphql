<?php

declare(strict_types=1);

namespace Domain\Bucket\QueryBuilders;

use Rebing\GraphQL\Support\SelectFields;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Domain\Bucket\DataTransferObjects\BucketsQueryArgsData;

class BucketQueryBuilder extends Builder
{
    public function findAll(SelectFields $fields, BucketsQueryArgsData $args): Collection
    {
        return $this->model->query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->when(
                value: null !== $args->archived,
                callback: fn(BucketQueryBuilder $q) => $q->where('archived', '=', $args->archived)
            )
            ->get();
    }
}
