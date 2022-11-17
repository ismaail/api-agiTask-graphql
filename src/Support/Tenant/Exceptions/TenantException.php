<?php

declare(strict_types=1);

namespace Support\Tenant\Exceptions;

use GraphQL\Error\Error;

class TenantException extends Error
{
    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'tenant';
    }
}
