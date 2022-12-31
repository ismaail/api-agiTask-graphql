<?php

declare(strict_types=1);

namespace Domain\User\QueryBuilders;

use Domain\User\Models\User;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\SelectFields;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Domain\User\DataTransferObjects\UsersQueryArgsData;

class UserQueryBuilder extends Builder
{
    public function me(SelectFields $fields): User
    {
        return $this->model->query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->where('id', '=', Auth::user()->id)
            ->first();
    }

    public function findPaginate(SelectFields $fields, UsersQueryArgsData $args): LengthAwarePaginator
    {
        return $this->model->query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->paginate($args->limit, page: $args->page);
    }
}
