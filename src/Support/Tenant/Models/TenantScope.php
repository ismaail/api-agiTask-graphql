<?php

declare(strict_types=1);

namespace Support\Tenant\Models;

use Support\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TenantScope
 * @package App\Tenant\Models
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TenantScope implements Scope
{
    public function __construct(private TenantManager $tenantManager)
    {
    }

    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(
            $this->tenantManager->getPrimaryKey(),
            $this->tenantManager->getTenant()->getTenantId(),
        );
    }
}
