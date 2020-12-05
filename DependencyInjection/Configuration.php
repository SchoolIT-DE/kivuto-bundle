<?php

namespace SchulIT\KivutoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder('kivuto');
        $root = $treeBuilder->getRootNode();

        $root->children()
            ->scalarNode('account')
                ->isRequired()
            ->end()
            ->scalarNode('endpoint')
                ->isRequired()
            ->end()
            ->scalarNode('secret_key')
                ->isRequired()
            ->end()
            ->scalarNode('data_resolver')
                ->isRequired()
            ->end()
            ->scalarNode('logger')
            ->end()
            ->scalarNode('guzzle')
                ->isRequired()
            ->end()
            ->arrayNode('fake')
                ->children()
                    ->booleanNode('enabled')
                        ->defaultFalse()
                    ->end()
                    ->scalarNode('endpoint')
                        ->defaultValue('https://example.com/')
                    ->end()
                    ->scalarNode('secret_key')
                        ->defaultValue('1234')
                    ->end()
                    ->scalarNode('account')
                        ->defaultValue('foo')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}