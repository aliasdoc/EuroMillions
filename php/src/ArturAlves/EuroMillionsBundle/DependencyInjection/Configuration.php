<?php

namespace ArturAlves\EuroMillionsBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('artur_alves_euro_millions');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
            // ->integerNode('teste')->end()
                ->arrayNode('rules')
                    ->children()
                        ->arrayNode('draw')
                            ->children()
                                ->arrayNode('numbers')
                                    ->children()
                                        ->integerNode('count')->end()
                                        ->arrayNode('range')
                                            ->children()
                                                ->integerNode('min')->end()
                                                ->integerNode('max')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('stars')
                                    ->children()
                                        ->integerNode('count')->end()
                                        ->arrayNode('range')
                                            ->children()
                                                ->integerNode('min')->end()
                                                ->integerNode('max')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('recurrency')
                                    ->children()
                                        ->scalarNode('type')->end()
                                        ->scalarNode('value')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
