<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AppExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('security.yml');
        $loader->load('services.yml');
        $loader->load('twig.yml');
        $loader->load('menu.yml');
        $loader->load('listeners/doctrine.yml');
        $loader->load('listeners/kernel.yml');

        $loader->load(sprintf('cache/%s.yml', $container->getParameter('kernel.environment')));
    }
}
