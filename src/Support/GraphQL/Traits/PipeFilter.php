<?php

declare(strict_types=1);

namespace Support\GraphQL\Traits;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;

trait PipeFilter
{
    private function filter(QueryBuilder $query, string $name, array $args, callable $callback = null): void
    {
        $value = $args[$name] ?? null;

        if (null === $value) {
            return;
        }

        if (null !== $callback) {
            $callback();
            return;
        }

        $query->where($name, $value);
    }
}
