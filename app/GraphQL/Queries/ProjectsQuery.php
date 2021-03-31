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
        return GraphQL::paginate(GraphQL::type('Project'));
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function resolve()
    {
        return Project::paginate();
    }
}
