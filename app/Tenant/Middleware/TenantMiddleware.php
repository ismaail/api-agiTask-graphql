<?php

declare(strict_types=1);

namespace App\Tenant\Middleware;

use Closure;
use App\Models\Board;
use Illuminate\Http\Request;
use App\Tenant\TenantManager;
use Illuminate\Http\JsonResponse;
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
     * @param int|null $tenantId
     *
     * @return \App\Models\Board
     *
     * @throws \App\Tenant\Exceptions\TenantException
     */
    private function resolveTenant(?int $tenantId): Board
    {
        $tenant = Board::find($tenantId);

        if (! $tenant) {
            throw new TenantException('No Tenant provided');
        }

        return $tenant;
    }
}
