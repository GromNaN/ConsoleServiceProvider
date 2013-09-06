<?php

namespace LExpress\Silex;

use Silex\Application as SilexApplication;
use Silex\ServiceProviderInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

/**
 * Basic ConsoleServiceProvider for Silex
 *
 * @author Jerome TAMARELLE <jerome@tamarelle.net>
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(SilexApplication $app)
    {
        $app['console.name'] = 'UNKNOWN';
        $app['console.version'] = 'UNKNOWN';
        $app['console'] = $app->share(function () use ($app) {
            $app->boot();

            $console = new ConsoleApplication($app['console.name'], $app['console.version']);

            foreach ($app->keys() as $key) {
                if (false === strpos($key, 'command.')) {
                    continue;
                }

                $command = $app[$key];

                if ($command instanceof Command) {
                    $console->add($command);
                }
            }

            return $console;
        });
    }

    public function boot(SilexApplication $app)
    {
        // Nothing to do
    }
}
