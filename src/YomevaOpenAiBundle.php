<?php

namespace Yomeva\OpenAiBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

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
            //> children
            ->children()
            ////> api_key
            ->scalarNode('api_key')
            ->defaultValue('')
            ->end()
            ////< api_key
            ////> beta
            ->booleanNode('beta')
            ->defaultFalse()
            ->end()
            ////< beta
            ->end()//< children
        ;
    }
}