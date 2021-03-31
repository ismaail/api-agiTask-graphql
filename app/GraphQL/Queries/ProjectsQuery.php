<?php

declare(strict_types=1);

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
class ProjectsQuery extends Query
{
    use PipeFilter;

    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Projects',
    ];

    /**
     * @return \GraphQL\Type\Definition\Type
     */
    public function type(): Type
    {
        return GraphQL::paginate('Project');
    }

    /**
     * @param $root
     * @param array $args
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve($root, array $args)
    {
        $query = Project::getQuery();

        $this->pipeFilterQuery($query, 'id', $args);
        $this->pipeFilterQuery($query, 'archived', $args);

        return $query->paginate();
    }
}
