<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class ProjectQuery
 * @package App\GraphQL\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class ProjectQuery extends Query
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Project',
        'description' => 'Get single Project',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return GraphQL::type('Project');
    }

    /**
     * @return array
     */
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::int()),
            ],
        ];
    }

    /**
     * @param $root
     * @param array $args
     *
     * @return \App\Models\Project|null
     */
    public function resolve($root, array $args)
    {
        return Project::whereId($args['id'])->first();
    }
}
