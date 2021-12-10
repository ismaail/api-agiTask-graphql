<?php

namespace App\Tenant\Models;

use App\Tenant\TenantManager;
use App\Tenant\Scopes\TenantScope;

/**
 * Trait HasTenant
 * @package App\Tenant\Models
 */
trait HasTenant
{
    /**
     * Boot Tenant Scope for the Model.
     */
    public static function bootHasTenant(): void
    {
        /** @var \App\Tenant\TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);

        static::addGlobalScope(new TenantScope($tenantManager));
    }
}
