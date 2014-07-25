# Pimple Doctrine Migrations service provider

Provides the [Doctrine DBAL Migrations][migrations] to Pimple (Silex, Cilex)
applications. Based on the Symfony [Doctrine Migrations Bundle][bundle].

Uses [Dragonfly Development's Pimple ORM service-provider][orm] to find
differences between your database schema and your entities.

Also registers a number of console commands using the [KnpLabs' Console
service-provider][console].

## Installation

1.  Composer require this package:

        composer require "rmasters/doctrine-migrations-service-provider:~1.0"

2.  Register in your application:

    ```php
    $app = new Silex\Application;
    $app = new Pimple\Container;

    $app->register(new KnpLabs\Provider\ConsoleServiceProvider, [
        'console.name' => 'Application',
        'console.version' => '1',
        'console.project_directory' => __DIR__ . '/../', // your project root
    ]);

    $app->register(new Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider, [
        'orm.proxies.dir' => __DIR__ . '/Proxies',
        'orm.em.options' => [
            'mappings' => [
                [
                    'type' => 'annotation',
                    'namespace' => 'Application\Entity',
                    'path' => __DIR__ . '/../src/Entity',
                    'resources_namespace' => 'Application\Entity',
                    'use_simple_annotation_reader' => false, // Set this to false if you import @ORM for annotations
                ],
            ],
        ],
    ]);

    $app->register(new Rossible\DoctrineMigrationsProvider\DoctrineMigrationsServiceProvider, [
        'doctrine.migrations.namespace' => 'Application\Migration',
        'doctrine.migrations.dir_name' => __DIR__ . '/../src/Migration',
    ]);
    ```

This package requires Pimple 3.x and uses the ServiceProviderInterface and
Container interfaces/type-hints that it provides. Silex 2.0 supports this, and
Cilex should do soon.

## Configuration

Service                         | Description                                   | Default
--------------------------------|-----------------------------------------------|--------------------------
doctrine.migrations.namespace   | Namespace migrations are under                | `Application\Migrations`
doctrine.migrations.dir\_name   | Directory of migration files                  | `app/DoctrineMigrations`
doctrine.migrations.table\_name | Name of table that tracks executed migrations | `"migration_versions"`
doctrine.migrations.name        | Name of migration suite                       | `"Application Migrations"`

## Commands

The commands [mirror those in the Doctrine Migrations bundle][commands] for
Symfony.

You will need to setup a PHP script that can execute console commands. See
[src/Resources/console.php](src/Resources/Console.php) for an example.

## License

Released under the [MIT License](LICENSE).

[migrations]: http://www.doctrine-project.org/projects/migrations.html
[orm]: https://github.com/dflydev/dflydev-doctrine-orm-service-provider
[bundle]: https://github.com/doctrine/DoctrineMigrationsBundle
[console]: https://github.com/KnpLabs/ConsoleServiceProvider
[commands]: http://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html#usage
