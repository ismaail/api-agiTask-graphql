<?php

namespace App\Tenant\Models;

/**
 * Interface TenantModel
 * @package \App\Tenant\Models
 */
interface TenantModel
{
    public function getTenantId(): int;
}
