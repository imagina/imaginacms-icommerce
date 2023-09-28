<?php

namespace Modules\Icommerce\Providers;

use Modules\Core\Providers\RoutingServiceProvider as CoreRoutingServiceProvider;

class RouteServiceProvider extends CoreRoutingServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\Icommerce\Http\Controllers';

    protected function getFrontendRoute(): string
    {
        return __DIR__.'/../Http/frontendRoutes.php';
    }

    protected function getBackendRoute(): string
    {
        return __DIR__.'/../Http/backendRoutes.php';
    }

    protected function getApiRoute(): string
    {
        return __DIR__.'/../Http/apiRoutes.php';
    }
}
