<?php

declare(strict_types=1);

namespace App\Tenant;

use App\Models\Board;

/**
 * Class Manager
 * @package App\Tenant
 */
class TenantManager
{
    /**
     * @var \App\Models\Board
     */
    private Board $tenant;

    /**
     * @return \App\Models\Board
     */
    public function getTenant(): Board
    {
        return $this->tenant;
    }

    /**
     * @param \App\Models\Board $tenant
     */
    public function setTenant(Board $tenant): void
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
