#!/usr/bin/env php
<?php

/**
 * Example configuration below. In practice, it is easier to create a bootstrap
 * file that contains this setup and returns $app, which is then included into a
 * web controller and this console file.
 * 
 * // console.php or web.php
 *     $app = require __DIR__ . '/bootstrap.php';
 *
 * // bootstrap.php
 *     $app = new Silex\Application;
 *     // ...register services...
 *     return $app;
 */

$app = new Silex\Application;

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

$app['console']->run();
