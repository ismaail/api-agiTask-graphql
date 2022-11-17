<?php

declare(strict_types=1);

namespace Support\Tenant\Middleware;

use Closure;
use Illuminate\Http\Request;
use Support\Tenant\TenantManager;
use Illuminate\Http\JsonResponse;
use Support\Tenant\Models\TenantModel;
use Support\Tenant\Exceptions\TenantException;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Request|JsonResponse
    {
        $tenantHeader = (int)$request->header('x-tenant-id');

        if (! $tenantHeader) {
            throw new TenantException('No X-TENANT-ID request header is provided');
        }

        $tenant = $this->resolveTenant($tenantHeader);

        /** @var \Support\Tenant\TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);
        $tenantManager->setTenant($tenant);

        return $next($request);
    }

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
