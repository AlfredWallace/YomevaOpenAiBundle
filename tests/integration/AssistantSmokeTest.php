<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\ModifyAssistantPayloadBuilder;

final class AssistantSmokeTest extends ClientTestCase
{
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
        $this->assertSame(200, $response->getStatusCode());

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
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testSmokeListAssistants(): void
    {
        $response = self::$client->listAssistants();
        $this->assertSame(200, $response->getStatusCode());
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
        $this->assertSame(200, $response->getStatusCode());

        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('name', $responseArray);
        $this->assertEquals('Modified test', $responseArray['name']);
    }

    /**
     * @depends testSmokeCreateAssistant
     * @depends testSmokeModifyAssistant
     * @depends testSmokeRetrieveAssistant
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeDeleteAssistant(string $id): void
    {
        $response = self::$client->deleteAssistant($id);
        $this->assertSame(200, $response->getStatusCode());
    }
}
