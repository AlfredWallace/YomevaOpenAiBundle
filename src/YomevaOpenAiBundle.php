<?php

namespace Yomeva\OpenAiBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

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
//        $container->services()
//            ->set('yomeva.open_ai.validator', ValidatorInterface::class)
//            ->factory([Validation::class, 'createValidator']);


        $container->services()
            ->set('yomeva.open_ai.client', OpenAiClient::class)
            ->arg(0, $config['api_key'])
//            ->arg(1, service('yomeva.open_ai.validator'))
            ->alias(OpenAiClient::class, 'yomeva.open_ai.client');
    }
}