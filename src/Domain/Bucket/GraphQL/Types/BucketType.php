<?php

declare(strict_types=1);

namespace Domain\Bucket\GraphQL\Types;

use Domain\Bucket\Models\Bucket;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BucketType extends GraphQLType
{
    /**
     * @var array<string, string>
     */
    protected $attributes = [
        'name' => 'Bucket',
        'description' => 'Bucket Type',
        'model' => Bucket::class,
    ];

    /**
     * @return array<string, array<string, \GraphQL\Type\Definition\ScalarType>>
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
        ];
    }
}
