<?php

declare(strict_types=1);

namespace Domain\Tenant\Models;

use Domain\Tenant\TenantManager;

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
        /** @var \Domain\Tenant\TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);

        static::addGlobalScope(new TenantScope($tenantManager));
    }
}
