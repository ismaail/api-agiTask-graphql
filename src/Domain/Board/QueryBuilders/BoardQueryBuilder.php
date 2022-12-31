<?php

declare(strict_types=1);

namespace Domain\Board\QueryBuilders;

use Domain\Board\Models\Board;
use Support\GraphQL\Traits\PipeFilter;
use Rebing\GraphQL\Support\SelectFields;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Domain\Board\DataTransferObjects\BoardsQueryArgsData;

class BoardQueryBuilder extends Builder
{
    use PipeFilter;

    /**
     * @param \Rebing\GraphQL\Support\SelectFields $fields
     * @param \Domain\Board\DataTransferObjects\BoardsQueryArgsData $args
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator<int, \Domain\Board\Models\Board>
     */
    public function findPaginate(SelectFields $fields, BoardsQueryArgsData $args): LengthAwarePaginator
    {
        return $this->model->query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->when(
                value: null !== $args->archived,
                callback: fn(BoardQueryBuilder $q) => $q->where('archived', $args->archived),
            )
            ->paginate(perPage: $args->limit, page: $args->page)
            ;
    }

    public function findById(int $id, SelectFields $fields): ?Board
    {
        return $this->model->query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->where('id', '=', $id)
            ->first()
            ;
    }
}
