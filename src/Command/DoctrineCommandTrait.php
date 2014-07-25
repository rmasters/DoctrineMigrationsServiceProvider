<?php

namespace Rossible\Provider\DoctrineMigrationsProvider\Command;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Exception;
use Pimple\Container;
use Symfony\Component\Console\Application;

trait DoctrineCommandTrait
{
    protected function configureMigrations(Container $container, Configuration $config)
    {
        $dir = $container['doctrine.migrations.dir_name'];
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $config->setMigrationsNamespace($container['doctrine.migrations.namespace']);
        $config->setMigrationsDirectory($dir);
        $config->registerMigrationsFromDirectory($dir);
        $config->setName($container['doctrine.migrations.name']);
        $config->setMigrationsTableName($container['doctrine.migrations.table_name']);
    }

    protected function setApplicationEntityManager(Container $container, Application $app, $emName)
    {
        if (!is_null($emName)) {
            if (!array_key_exists($emName, $container['orm.ems'])) {
                throw new Exception(sprintf('Unknown Doctrine entity manager "%s"', $emName));
            }
        } else {
            $emName = 'default';
        }

        /** @var EntityManager $em */
        $em = $container['orm.ems'][$emName];

        $app->getHelperSet()->set(new ConnectionHelper($em->getConnection()), 'db');
        $app->getHelperSet()->set(new EntityManagerHelper($em), 'em');
    }

    protected function setApplicationConnection(Container $container, Application $app, $connName)
    {
        if (is_null($connName)) {
            if (!array_key_exists($connName, $container['dbs'])) {
                throw new Exception(sprintf('Unknown Doctrine connection "%s"', $connName));
            }

            $db = $container['dbs'][$connName];
        } else {
            $db = $container['db'];
        }

        $app->getHelperSet()->set(new ConnectionHelper($db), 'db');
    }
}