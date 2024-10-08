<?php

namespace Yomeva\OpenAiBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

class YomevaOpenAiBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->scalarNode('api_key')
            ->defaultValue('')
            ->end() // api_key
            ->end() // children
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');

        $container->services()
            ->get('Yomeva\OpenAiBundle\Service\OpenAiClient')
            ->arg(0, $config['api_key'])
            ->alias('yomeva.open_ai', OpenAiClient::class);
    }
}