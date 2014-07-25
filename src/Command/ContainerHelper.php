<?php

namespace Rossible\Provider\DoctrineMigrationsProvider\Command;

use Pimple\Container;
use Symfony\Component\Console\Helper\Helper;

/**
 * A Symfony console Helper that holds the Pimple container
 */
class ContainerHelper extends Helper
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'pimple';
    }
}