<?php

declare(strict_types=1);

namespace App\Tenant;

use App\Tenant\Models\TenantModel;

/**
 * Class Manager
 * @package App\Tenant
 */
class TenantManager
{
    /**
     * @var \App\Tenant\Models\TenantModel
     */
    private TenantModel $tenant;

    /**
     * @return \App\Tenant\Models\TenantModel
     */
    public function getTenant(): TenantModel
    {
        return $this->tenant;
    }

    /**
     * @param \App\Tenant\Models\TenantModel $tenant
     */
    public function setTenant(TenantModel $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * @const string
     */
    public function getPrimaryKey(): string
    {
        return 'tenant_id';
    }
}
