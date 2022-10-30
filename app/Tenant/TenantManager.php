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

    public function getTenant(): TenantModel
    {
        return $this->tenant;
    }

    public function setTenant(TenantModel $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function getPrimaryKey(): string
    {
        return 'tenant_id';
    }
}
