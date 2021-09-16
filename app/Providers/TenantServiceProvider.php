<?php

namespace App\Providers;

use App\Tenant\TenantManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

/**
 * Class TenantProvider
 * @package App\Providers
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
