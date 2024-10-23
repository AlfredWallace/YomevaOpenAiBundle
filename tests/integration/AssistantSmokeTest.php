<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\ModifyAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

final class AssistantSmokeTest extends TestCase
{
    private static OpenAiClient $client;

    public static function setUpBeforeClass(): void
    {
        // this has to be a key for an OpenAI project used for tests where all data can be deleted
        self::$client = new OpenAiClient($_ENV['OPEN_AI_API_KEY']);
        parent::setUpBeforeClass();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSmokeCreateAssistant(): string
    {
        $response = self::$client->createAssistant(
            (new CreateAssistantPayloadBuilder('gpt-4o'))
                ->getPayload()
        );
        $this->assertEquals('200', $response->getStatusCode());

        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('id', $responseArray);

        $id = $responseArray['id'];
        $this->assertIsString($id);

        return $id;
    }

    /**
     * @depends testSmokeCreateAssistant
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeRetrieveAssistant(string $id): void
    {
        $response = self::$client->retrieveAssistant($id);
        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateAssistant
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSmokeListAssistants(string $id): void
    {
        $response = self::$client->listAssistants();
        $this->assertEquals('200', $response->getStatusCode());

        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('data', $responseArray);
        $this->assertIsArray($responseArray['data']);

        $ids = [];
        foreach ($responseArray['data'] as $assistant) {
            $this->assertIsArray($assistant);
            $this->assertArrayHasKey('id', $assistant);
            $ids[] = $assistant['id'];
        }

        $this->assertContains($id, $ids);
    }

    /**
     * @depends testSmokeCreateAssistant
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSmokeModifyAssistant(string $id): void
    {
        $response = self::$client->modifyAssistant(
            $id,
            (new ModifyAssistantPayloadBuilder())->setName('Modified test')->getPayload()
        );
        $this->assertEquals('200', $response->getStatusCode());

        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertEquals('Modified test', $responseArray['name']);
    }

    /**
     * @depends testSmokeCreateAssistant
     * @depends testSmokeListAssistants
     * @depends testSmokeModifyAssistant
     * @depends testSmokeRetrieveAssistant
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeDeleteAssistant(string $id): void
    {
        $response = self::$client->deleteAssistant($id);
        $this->assertEquals('200', $response->getStatusCode());
    }
}
