<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Command\RegisterAddCommand;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DataLoader implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $this->container->get('command_bus')->handle(new RegisterAddCommand('tony', 'master'));
        $this->container->get('command_bus')->handle(new RegisterAddCommand('john', 'master'));
    }
}
