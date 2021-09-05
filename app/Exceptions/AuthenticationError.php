<?php

namespace App\Exceptions;

use GraphQL\Error\Error;

/**
 * Class AuthenticationError
 */
class AuthenticationError extends Error
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
        return 'authentication';
    }
}
