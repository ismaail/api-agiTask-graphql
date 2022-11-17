<?php

declare(strict_types=1);

namespace Domain\User\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
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
 * @phpcs:disable Generic.Files.LineLength.TooLong
 */
class ProfileQuery extends Query
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'me',
        'description' => 'User Profile',
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('User'));
    }

    public function resolve(mixed $root, array $args, User $context, ResolveInfo $resolveInfo, Closure $getSelectFields): User
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $with = $fields->getRelations();

        return Auth
            ::user()
            ->load($with);
    }
}
