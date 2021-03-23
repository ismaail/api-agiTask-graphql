<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class UserQuery
 * @package App\GraphQL\Queries
 */
class UserQuery extends Query
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Users',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    /**
     * @return \App\Models\User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function resolve()
    {
        return User::all();
    }
}
