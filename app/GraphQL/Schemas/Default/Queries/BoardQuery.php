<?php

declare(strict_types=1);

namespace App\GraphQL\Schemas\Default\Queries;

use Closure;
use App\Models\User;
use App\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class BoardQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @phpcs:disable Generic.Files.LineLength.TooLong
 *
 */
class BoardQuery extends Query
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'board',
        'description' => 'Find single Board by ID.',
    ];

    public function type(): Type
    {
        return GraphQL::type('Board');
    }

    /**
     * @return array<string, array<string, \GraphQL\Type\Definition\ScalarType>>
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
            ],
        ];
    }

    public function resolve(mixed $root, array $args, User $context, ResolveInfo $resolveInfo, Closure $getSelectFields): ?Board
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return Board
            ::where('id', $args['id'])
            ->with($with)
            ->select($select)
            ->first();
    }
}
