<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAiClient
{
    public function __construct(
        private HttpClientInterface $client,
        private readonly string     $openAiApiKey
    )
    {
    }

    public function helloWorld(): string
    {
        return 'Hello World! Voici mon API key : ' . $this->openAiApiKey;
    }
}