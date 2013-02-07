<?php

namespace LExpress\Silex;

use Silex\Application as SilexApplication;
use Silex\ServiceProviderInterface;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * Basic ConsoleServiceProvider for Silex
 * 
 * @author Jerome TAMARELLE <jerome@tamarelle.net>
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(SilexApplication $app)
    {
        $app['console.name'] = null;
        $app['console.version'] = null;
        $app['console'] = $app->share(function () use ($app) {
            $app->boot();

            $console = new ConsoleApplication($app['console.name'],$app['console.version']);

            return $console;
        });
    }

    public function boot()
    {
        // Nothing to do
    }
}
