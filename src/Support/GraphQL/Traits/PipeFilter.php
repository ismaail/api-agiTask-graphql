<?php

declare(strict_types=1);

namespace Support\GraphQL\Traits;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;

/**
 * Trait PipeFilter
 * @package App\GraphQL\Queries
 */
trait PipeFilter
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @param array $args
     * @param callable|null $callback
     */
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
