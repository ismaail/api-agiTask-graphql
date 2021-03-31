<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Project;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphqlType;

/**
 * Class ProjectType
 * @package App\Graphql\Types
 */
class ProjectType extends GraphqlType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Project',
        'model' => Project::class,
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
            'archived' => [
                'type' => Type::nonNull(Type::boolean()),
            ],
            'owner' => [
                'type' => Type::nonNull(GraphQL::type('User')),
            ]
        ];
    }
}
