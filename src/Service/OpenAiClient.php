<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OpenAiClient
{
    private HttpClientInterface $client;

    public function __construct(private readonly string $openAiApiKey)
    {
        $this->client = HttpClient::create(
            defaultOptions: [
                'base_uri' => 'https://api.openai.com/v1/',
                'headers' => [
//                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $this->openAiApiKey",
                ]
            ]
        );
    }

    public function listModels(): ResponseInterface
    {
        return $this->client->request('GET', 'models');
    }
}