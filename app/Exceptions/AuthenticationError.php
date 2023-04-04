<?php

declare(strict_types=1);

namespace App\Exceptions;

use GraphQL\Error\Error;

class AuthenticationError extends Error
{
    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'authentication';
    }
}
