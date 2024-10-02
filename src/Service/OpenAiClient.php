<?php

namespace Yomeva\OpenAiBundle\Service;

class OpenAiClient
{
    public function __construct(private string $openAiApiKey)
    {
    }

    public function helloWorld(): string
    {
        return 'Hello World! This is v0.1.2';
    }
}