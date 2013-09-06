<?php

namespace LExpress\Silex\Tests;

use Silex\Application;
use Symfony\Component\Console\Command\Command;
use LExpress\Silex\ConsoleServiceProvider;

class ConsoleServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandRegistration()
    {
        $app = new Application();
        $app->register(new ConsoleServiceProvider());

        $app['command.not_a_command'] = 'Not a command !';
        $app['command.lazy_service'] = $app->share(function () {
            return new Command('foo:my_lazy_service');
        });
        $app['command.object'] = new Command('foo:my_object');

        $commands = $app['console']->all();

        $this->assertContains($app['command.lazy_service'], $commands, 'command.lazy_service');
        $this->assertContains($app['command.object'], $commands, 'command.object');
        $this->assertNotContains($app['command.not_a_command'], $commands, 'command.not_a_command');
    }

    public function testCommandNameAndVersion()
    {
        $app = new Application();
        $app->register(new ConsoleServiceProvider(), array(
            'console.name' => 'My Console',
            'console.version' => '10.5.9',
        ));

        $this->assertEquals('My Console', $app['console']->getName());
        $this->assertEquals('10.5.9', $app['console']->getVersion());
    }

    public function testApplicationIsBooted()
    {
        $app = new Application();
        $app->register(new ConsoleServiceProvider());

        $mockProvider = $this->getMock('Silex\\ServiceProviderInterface');
        $mockProvider->expects($this->once())->method('boot');

        $app->register($mockProvider);

        $app['console'];
    }
}
