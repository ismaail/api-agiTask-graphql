<?php

namespace App\GraphQL\Queries;

use App\Models\Project;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

/**
 * Class ProjectQuery
 * @package App\Graphql\Queries
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class ProjectQuery extends Query
{
    use PipeFilter;

    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Projects',
    ];

    /**
     * @return array[]
     */
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
            ],
            'archived' => [
                'name' => 'archived',
                'type' => Type::boolean(),
            ],
        ];
    }

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Project'));
    }

    /**
     * @param $root
     * @param array $args
     *
     * @return \App\Models\Project[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function resolve($root, array $args)
    {
        $query = Project::getQuery();

        $this->pipeFilterQuery($query, 'id', $args);
        $this->pipeFilterQuery($query, 'archived', $args);

        return $query->get();
    }
}
