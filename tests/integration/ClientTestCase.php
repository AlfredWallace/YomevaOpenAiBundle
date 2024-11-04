<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Exception\CheckStagingEnvException;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

abstract class ClientTestCase extends TestCase
{
    protected static OpenAiClient $client;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // this has to be a key for an OpenAI project used for tests where all data can be deleted
        // having a different name than the one used in the project where you install the bundle
        // (OPEN_AI_API_TEST_KEY instead of OPEN_AI_API_KEY) is a small security enhancement to
        // reduce the chances to run tests in a prod environment
        self::$client = new OpenAiClient($_ENV['OPEN_AI_API_TEST_KEY']);

        $checkEnvResponse = self::$client->listAssistants();
        $assistants = $checkEnvResponse->toArray(false);

        if (
            !array_key_exists('data', $assistants)
            || count($assistants['data']) !== 1
            || !array_key_exists('name', $assistants['data'][0])
            || $assistants['data'][0]['name'] !== CheckStagingEnvException::STAGING_ASSISTANT_NAME
        ) {
            throw new CheckStagingEnvException();
        }
    }
}