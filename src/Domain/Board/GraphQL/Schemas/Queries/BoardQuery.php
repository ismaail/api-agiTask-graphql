<?php

declare(strict_types=1);

namespace Domain\Board\GraphQL\Schemas\Queries;

use Closure;
use Domain\User\Models\User;
use Domain\Board\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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

    public function resolve(
        mixed $root,
        array $args,
        User $context,
        ResolveInfo $resolveInfo,
        Closure $getSelectFields,
    ): ?Board {
        return Board::findById($args['id'], $getSelectFields());
    }
}
