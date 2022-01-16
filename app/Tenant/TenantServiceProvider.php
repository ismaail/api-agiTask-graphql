<?php

declare(strict_types=1);

namespace App\Tenant;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

/**
 * Class TenantProvider
 * @package App\Tenant
 */
class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register TenantManager Service Provider.
     */
    public function register(): void
    {
        App::singleton(TenantManager::class, fn() => new TenantManager());
    }
}
