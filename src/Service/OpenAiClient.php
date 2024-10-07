<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Yomeva\OpenAiBundle\Exception\NotImplementedException;

class OpenAiClient
{
    private HttpClientInterface $client;

    public function __construct(private readonly string $openAiApiKey)
    {
        $this->client = HttpClient::create(
            defaultOptions: [
                'base_uri' => 'https://api.openai.com/v1/',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $this->openAiApiKey",
                ]
            ]
        );
    }

    ///> AUDIO

    // https://api.openai.com/v1/audio/speech
    public function createSpeech(): ResponseInterface
    {
        throw new NotImplementedException();
    }

    ///< AUDIO


    ///> MODELS

    /**
     * @throws TransportExceptionInterface
     */
    public function listModels(): ResponseInterface
    {
        return $this->client->request('GET', 'models');
    }

    ///< MODELS
}