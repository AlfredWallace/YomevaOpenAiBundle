<?php

declare(strict_types=1);

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

final class CreateAssistantTest extends TestCase
{
    private OpenAiClient $client;
    private string $assistantId;

    protected function setUp(): void
    {
        // this has to be a key for an OpenAI project used for tests where all data can be deleted
        $this->client = new OpenAiClient($_ENV['OPEN_AI_API_KEY']);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testCreateBasicAssistant(): void
    {
        $response = $this->client->createAssistant(
            (new CreateAssistantPayloadBuilder('gpt-4o'))
                ->getPayload()
        );

        $this->assistantId = $response->toArray(false)['id'];

        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function tearDown(): void
    {
        $this->client->deleteAssistant($this->assistantId)->getContent(false);
        parent::tearDown();
    }
}
