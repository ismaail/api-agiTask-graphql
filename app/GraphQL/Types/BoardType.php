<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Board;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphqlType;

/**
 * Class ProjectType
 * @package App\Graphql\Types
 */
class BoardType extends GraphqlType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Board',
        'model' => Board::class,
    ];

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'archived' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            //'owner' => [
            //    'type' => Type::nonNull(GraphQL::type('User')),
            //]
        ];
    }
}