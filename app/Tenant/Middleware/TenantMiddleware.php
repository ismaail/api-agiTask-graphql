<?php

declare(strict_types=1);

namespace App\Tenant\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Tenant\TenantManager;
use Illuminate\Http\JsonResponse;
use App\Tenant\Models\TenantModel;
use App\Tenant\Exceptions\TenantException;

/**
 * Class TenantMiddleware
 * @package App\Http\Middleware
 */
class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return \Illuminate\Http\Request|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next): Request|JsonResponse
    {
        $tenant = $this->resolveTenant((int)$request->header('x-tenant-id'));

        /** @var \App\Tenant\TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);
        $tenantManager->setTenant($tenant);

        return $next($request);
    }

    /**
     * @param int $tenantId
     *
     * @return \App\Tenant\Models\TenantModel
     *
     * @throws \App\Tenant\Exceptions\TenantException
     */
    private function resolveTenant(int $tenantId): TenantModel
    {
        $modelClass = config('tenant.base_model');
        $tenant = app()->make($modelClass)::find($tenantId);

        if (! $tenant) {
            throw new TenantException('No Tenant provided');
        }

        return $tenant;
    }
}
