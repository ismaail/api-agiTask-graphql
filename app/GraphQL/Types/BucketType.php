<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Bucket;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Class BucketType
 * @package App\GraphQL\Types
 */
class BucketType extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Bucket',
        'description' => 'Bucket Type',
        'model' => Bucket::class,
    ];

    /**
     * @return array[]
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
