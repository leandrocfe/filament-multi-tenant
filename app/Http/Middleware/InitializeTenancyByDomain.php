<?php

namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain as BaseInitializeTenancyByDomain;

class InitializeTenancyByDomain extends BaseInitializeTenancyByDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Skip for central domains
        if (in_array($request->getHost(), config('tenancy.central_domains'), true)) {
            return $next($request);
        }

        return $this->initializeTenancy(
            $request,
            $next,
            $request->getHost()
        );
    }

    public function initializeTenancy($request, $next, ...$resolverArguments)
    {
        try {
            $this->tenancy->initialize(
                $this->resolver->resolve(...$resolverArguments)
            );
        } catch (TenantCouldNotBeIdentifiedException $e) {
            $onFail = static::$onFail ?? function ($e) {
                throw $e;
            };

            return $onFail($e, $request, $next);
        }

        return $next($request);
    }
}
