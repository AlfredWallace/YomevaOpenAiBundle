<?php

namespace Yomeva\OpenAiBundle\Service;

class OpenAiClient
{
    public function __construct(private readonly string $openAiApiKey)
    {
    }

    public function helloWorld(): string
    {
        return 'Hello World! Voici mon API key : ' . $this->openAiApiKey;
    }
}