<?php

namespace App\Tenant\Middleware;

use Closure;
use App\Models\Board;
use Illuminate\Http\Request;
use App\Tenant\TenantManager;
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
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant = $this->resolveTenant($request->header('x-tenant-id'));

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
