<?php

declare(strict_types=1);

namespace Support\Tenant\Models;

use Support\Tenant\TenantManager;

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
        /** @var \Support\Tenant\TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);

        static::addGlobalScope(new TenantScope($tenantManager));
    }
}
