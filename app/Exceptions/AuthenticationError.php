<?php

namespace App\Exceptions;

use GraphQL\Error\Error;

/**
 * class AuthenticationError
 * @package App\Exceptions
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
