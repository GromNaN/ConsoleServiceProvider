# Console Service Provider for Silex

The ConsoleServiceProvider enable [Symfony Console](http://symfony.com/doc/current/components/console/introduction.html)
in [Silex](http://silex.sensiolabs.org/) make easy to register command from any other service provider.

## Parameters

* __console.name (optional):__ The name of your application.
* __console.version (optional):__ The version of your application.

## Services

* __console:__ The Console Application. Use `$app['console']->run()`.

## Registering

Installation:

* Use the official Git repository (https://github.com/LExpress/ConsoleServiceProvider);
* Install it via [Composer](http://getcomposer.org) (lexpress/console-service-provider on Packagist).

Register the service provider in your Silex application.

```php
$app->register(new LExpress\Silex\ConsoleServiceProvider(), array(
    'console.name'    => 'Wahou',
    'console.version' => '1.0',
));
```

## Register commands

Services named with `command.*` are automatically registered to the console.

```php
$app['command.propel.model.build'] = $app->share(function ($app) {
    return new Propel\Generator\Command\ModelBuildCommand();
});
```

## Running the console application

The Console Application is available in your Silex Application with the service alias `console`.
To run it, you can create an executable file in your project.

```php
#!/usr/bin/env php
<?php

// Load the class loader
require __DIR__.'/vendor/autoload.php';

// Initialize your application with the ConsoleServiceProvider
$app = require __DIR__.'/app.php';

// Run the console with the default input/output
$app['console']->run();
```

# License

ConsoleServiceProvider is licensed under the MIT license.
