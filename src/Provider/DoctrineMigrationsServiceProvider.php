<?php

namespace Rossible\Provider\DoctrineMigrationsProvider\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

use Knp\Console\ConsoleEvents;
use Knp\Console\ConsoleEvent;

use Rossible\Provider\DoctrineMigrationsProvider\Command;

class DoctrineMigrationsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        /**
         * Default configuration
         */
        $app['doctrine.migrations.namespace'] = 'Application\Migrations';
        $app['doctrine.migrations.dir_name'] = 'app/DoctrineMigrations';
        $app['doctrine.migrations.table_name'] = 'migration_versions';
        $app['doctrine.migrations.name'] = 'Application Migrations';

        /**
         * Register commands
         */
        $app['dispatcher']->addListener(ConsoleEvents::INIT, function (ConsoleEvent $event) use ($app) {
            $console = $event->getApplication();

            $console->getHelperSet()->set(new Command\ContainerHelper($app));

            $console->add(new Command\MigrationsDiffCommand);
            $console->add(new Command\MigrationsExecuteCommand);
            $console->add(new Command\MigrationsGenerateCommand);
            $console->add(new Command\MigrationsLatestCommand);
            $console->add(new Command\MigrationsMigrateCommand);
            $console->add(new Command\MigrationsStatusCommand);
            $console->add(new Command\MigrationsVersionCommand);
        });
    }
}
