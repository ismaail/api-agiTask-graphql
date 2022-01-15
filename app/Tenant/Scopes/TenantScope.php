<?php

declare(strict_types=1);

namespace App\Tenant\Scopes;

use App\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TenantScope
 * @package App\Models
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TenantScope implements Scope
{
    /**
     * TenantScope constructor.
     *
     * @param \App\Tenant\TenantManager $tenantManager
     */
    public function __construct(private TenantManager $tenantManager)
    {
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(
            $this->tenantManager->getPrimaryKey(),
            $this->tenantManager->getTenant()->getTenantId(),
        );
    }
}
