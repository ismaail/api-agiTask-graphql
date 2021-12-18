<?php

declare(strict_types=1);

namespace App\Tenant\Exceptions;

use GraphQL\Error\Error;

/**
 * Class TenantException
 * @package App\Exceptions
 */
class TenantException extends Error
{
    /**
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return 'tenant';
    }
}
