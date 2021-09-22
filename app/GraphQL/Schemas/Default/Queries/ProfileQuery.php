<?php

declare(strict_types=1);

namespace App\GraphQL\Schemas\Default\Queries;

use Closure;
use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class ProfileQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 */
class ProfileQuery extends Query
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'me',
        'description' => 'User Profile',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('User'));
    }

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo
     * @param \Closure $getSelectFields
     *
     * @return \App\Models\User
     */
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields): User
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $with = $fields->getRelations();

        return Auth
            ::user()
            ->load($with);
    }
}
