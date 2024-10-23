<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\CreateThreadPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\ModifyThreadPayloadBuilder;

class ThreadSmokeTest extends ClientTestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testSmokeCreateThread(): string
    {
        $response = self::$client->createThread(
            (new CreateThreadPayloadBuilder())->getPayload()
        );
        $this->assertEquals('200', $response->getStatusCode());

        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('id', $responseArray);

        $id = $responseArray['id'];
        $this->assertIsString($id);

        return $id;
    }

    /**
     * @depends testSmokeCreateThread
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeRetrieveThread(string $id): void
    {
        $response = self::$client->retrieveThread($id);
        $this->assertEquals('200', $response->getStatusCode());
    }

    /**
     * @depends  testSmokeCreateThread
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSmokeModifyThread(string $id): void
    {
        $response = self::$client->modifyThread(
            $id,
            (new ModifyThreadPayloadBuilder())->addMetadata("foo", "bar")->getPayload()
        );
        $this->assertEquals('200', $response->getStatusCode());

        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('metadata', $responseArray);
        $this->assertIsArray($responseArray['metadata']);
        $this->assertArrayHasKey("foo", $responseArray['metadata']);
        $this->assertEquals('bar', $responseArray['metadata']['foo']);
    }

    /**
     * @depends testSmokeCreateThread
     * @depends testSmokeModifyThread
     * @depends testSmokeRetrieveThread
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeDeleteThread(string $id): void
    {
        $response = self::$client->deleteThread($id);
        $this->assertEquals('200', $response->getStatusCode());
    }
}