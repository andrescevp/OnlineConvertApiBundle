<?php

namespace Aacp\OnlineConvertApiBundle\DependencyInjection;

use Qaamgo\Configuration as OcSdkApiConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AacpOnlineConvertApiExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container = $this->loadMainConfig($container, $config);

        $this->loadConversions($container, $config);

    }

    private  function loadMainConfig(ContainerBuilder $container, $config)
    {
        foreach ($config as $key => $value) {
            $container->setParameter('oc.'.$key, $value);
        }

        if ($container->getParameter('oc.debug') === true) {
            OcSdkApiConfig::$debug = true;
        }

        if ($container->getParameter('oc.convert_to_all') === true) {
            $container = $this->enableAllConversions($container);
        }

        return $container;
    }

    private function loadConversions(ContainerBuilder $container, $config)
    {
        if (empty($config['jobs'])) {
            return $container;
        }
        foreach($config['jobs'] as $name => $job) {
            $container->setDefinition(
                'oc.job.' . $name,
                $container
                    ->getDefinition('oc.base_conversion')
                    ->addMethodCall('setCategory', [$job['category']])
                    ->addMethodCall('setTarget', [$job['target']])
            );
        }

        return $container;
    }

    private function enableAllConversions(ContainerBuilder $container)
    {
        $container->setDefinition('oc.job.convert_to_all', $container->getDefinition('oc.all_conversions'));
        return $container;
    }
}
