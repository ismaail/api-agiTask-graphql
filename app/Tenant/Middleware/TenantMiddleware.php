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
    public function handle(Request $request, Closure $next): Request|JsonResponse
    {
        $tenantHeader = (int)$request->header('x-tenant-id');

        if (! $tenantHeader) {
            throw new TenantException('No X-TENANT-ID request header is provided');
        }

        $tenant = $this->resolveTenant($tenantHeader);

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
            throw new TenantException('Tenant not found');
        }

        return $tenant;
    }
}
