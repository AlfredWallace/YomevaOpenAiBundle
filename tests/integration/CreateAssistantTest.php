<?php

declare(strict_types=1);

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

final class CreateAssistantTest extends TestCase
{
    private static OpenAiClient $client;
    private ?string $assistantId = null;

    public static function setUpBeforeClass(): void
    {
        // this has to be a key for an OpenAI project used for tests where all data can be deleted
        self::$client = new OpenAiClient($_ENV['OPEN_AI_API_KEY']);
        parent::setUpBeforeClass();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws ExceptionInterface
     */
    public function testCreateBasicAssistant(): void
    {
        $response = self::$client->createAssistant(
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
        if ($this->assistantId !== null) {
            self::$client->deleteAssistant($this->assistantId)->getContent(false);
        }
        parent::tearDown();
    }
}
