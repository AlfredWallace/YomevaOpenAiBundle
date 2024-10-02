<?php

namespace Yomeva\OpenAiBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class YomevaOpenAiBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->scalarNode('open_ai_api_key')->end()
            ->end() // children
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');

        dump($config);
//        $container->services()
//            ->get('Yomeva\OpenAiBundle\Service\OpenAiClient')
//            ->arg(0, $config['open_ai_api_key']);
    }
}