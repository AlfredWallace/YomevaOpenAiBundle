<?php

namespace Yomeva\OpenAiBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

class YomevaOpenAiBundle extends AbstractBundle
{
    /**
     * The configuration contains only one variable, api_key, which must contain one of your OpenAI API key.
     * The provided key should depend on the environment of your app, which should be matched with an OpenAI project.
     *
     * @param DefinitionConfigurator $definition
     * @return void
     */
    public function configure(DefinitionConfigurator $definition): void
    {
        // We are not here to fix the typing of symfony
        /** @phpstan-ignore-next-line */
        $definition->rootNode()
            ->children()
            ->scalarNode('api_key')
            ->defaultValue('')
            ->end() // api_key
            ->end() // children
        ;
    }

    /**
     * The bundle exposes only one service, the client allowing you to easily make calls on the OpenAI APIs.
     *
     * @param array<string, mixed> $config
     * @param ContainerConfigurator $container
     * @param ContainerBuilder $builder
     * @return void
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->services()
            ->set('yomeva.open_ai.client', OpenAiClient::class)
            ->arg(0, $config['api_key'])
            ->alias(OpenAiClient::class, 'yomeva.open_ai.client');
    }
}