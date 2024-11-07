<?php

namespace Yomeva\OpenAiBundle\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Yomeva\OpenAiBundle\Builder\SerializerBuilder;

/**
 * This service is the entry point of the bundle. You should inject it wherever you need, and use functions to
 * make calls to the OpenAI APIs, thanks to the api_key you provided in the configuration.
 */
class OpenAiClient
{
    private HttpClientInterface $httpClient;
    private ValidatorInterface $validator;
    private Serializer $serializer;

    /**
     * This client initializes :
     * - a Symfony HTTP client with basic headers needed by the OpenAI APIs and ths OpenAI base URI as default
     * - a Symfony Validator
     * - a Symfony Serializer initialized with a dedicated configuration (check the SerializerBuilder)
     *
     * An OpenAI API key. This should ideally come from an ENV VAR.
     * @param string $openAiApiKey
     * @param bool $beta
     */
    public function __construct(
        private readonly string $openAiApiKey,
        bool $beta
    ) {
        $options = (new HttpOptions())
            ->setBaseUri('https://api.openai.com/v1/')
            ->setHeader('Content-Type', 'application/json')
            ->setHeader('Authorization', "Bearer {$this->openAiApiKey}");

        if ($beta) {
            $options->setHeader('OpenAI-Beta', 'assistants=v2');
        }

        $this->httpClient = HttpClient::create()->withOptions($options->toArray());

        $this->validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();

        $this->serializer = (new SerializerBuilder())->makeSerializer();
    }
}
