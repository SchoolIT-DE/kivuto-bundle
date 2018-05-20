<?php

namespace SchoolIT\KivutoBundle\DependencyInjection;

use SchoolIT\KivutoBundle\Client\FakeKivutoClient;
use SchoolIT\KivutoBundle\Client\KivutoClient;
use SchoolIT\KivutoBundle\Client\KivutoClientInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KivutoExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['fake']) && $config['fake']['enabled']) {
            $definition = new Definition(FakeKivutoClient::class);
            $definition->setArguments([
                $config['fake']['endpoint'],
                $config['fake']['secret_key'],
                new Reference($config['data_resolver']),
                new Reference("request_stack")
            ]);
        } else {
            $definition = new Definition(KivutoClient::class);
            $definition->setArguments([
                $config['endpoint'],
                $config['secret_key'],
                new Reference($config['guzzle']),
                new Reference($config['data_resolver']),
                new Reference("request_stack"),
                isset($config['logger']) ? new Reference($config['logger']) : null
            ]);
        }

        $definition->setPublic(false);
        $container->setDefinition('kivuto.client', $definition);

        $container->register(KivutoClientInterface::class)
            ->setPublic(false);
        $container->setAlias(KivutoClientInterface::class, 'kivuto.client');
    }
}