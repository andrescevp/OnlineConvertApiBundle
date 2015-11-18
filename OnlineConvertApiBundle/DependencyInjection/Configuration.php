<?php

namespace Aacp\OnlineConvertApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aacp_online_convert_api');
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->loadGeneral($rootNode);
        $this->loadConversions($rootNode);

        return $treeBuilder;
    }

    private function loadGeneral(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->scalarNode('api_key')
            ->isRequired()
            ->end();
        $rootNode
            ->children()
            ->scalarNode('host')
            ->isRequired()
            ->end();
        $rootNode
            ->children()
            ->booleanNode('logging')
            ->defaultValue(false)
            ->end();
        $rootNode
            ->children()
            ->booleanNode('debug')
            ->defaultValue(false)
            ->end();
        $rootNode
            ->children()
            ->booleanNode('https')
            ->defaultValue(false)
            ->end();
        $rootNode
            ->children()
            ->booleanNode('convert_to_all')
            ->defaultValue(false)
            ->end();
    }

    private function loadConversions(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('jobs')
                ->canBeUnset()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('category')->isRequired()->end()
                            ->scalarNode('target')->isRequired()->end()
                            ->scalarNode('async')->defaultValue(false)->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

}
