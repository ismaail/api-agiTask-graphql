<?php

declare(strict_types=1);

namespace Domain\Tenant;

use Domain\Tenant\Models\TenantModel;

/**
 * Class Manager
 * @package App\Tenant
 */
class TenantManager
{
    /**
     * @var \Domain\Tenant\Models\TenantModel
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
