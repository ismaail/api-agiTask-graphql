<?php

declare(strict_types=1);

namespace Support\Tenant\Models;

interface TenantModel
{
    public function getTenantId(): int;
}
