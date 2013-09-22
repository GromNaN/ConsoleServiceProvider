<?php

/*
 * This file is part of LExpress / ConsoleServiceProvider.
 *
 * (c) Groupe Express Roularta - Jérôme Tamarelle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LExpress\Silex;

use Silex\Application as SilexApplication;
use Silex\ServiceProviderInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

/**
 * Basic ConsoleServiceProvider for Silex
 *
 * @author Jérôme TAMARELLE <jerome@tamarelle.net>
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
            $console->setCatchExceptions($app['debug']);
            $console->setDispatcher($app['dispatcher']);

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
