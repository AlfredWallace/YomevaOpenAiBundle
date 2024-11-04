<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Message\ModifyMessagePayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\CreateThreadPayloadBuilder;
use Yomeva\OpenAiBundle\Model\Message\Role;

class MessageSmokeTest extends ClientTestCase
{
    private static string $threadId;

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $threadResponse = self::$client->createThread(
            (new CreateThreadPayloadBuilder())->getPayload()
        );
        self::$threadId = $threadResponse->toArray(false)['id'];
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        $threadResponse = self::$client->deleteThread(self::$threadId);
        $threadResponse->toArray(false); // to block async
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testSmokeCreateMessage(): string
    {
        $messageResponse = self::$client->createMessage(
            self::$threadId,
            (new CreateMessagePayloadBuilder(Role::User, "Simple message"))->getPayload()
        );
        $this->assertSame(200, $messageResponse->getStatusCode());

        $messageArray = $messageResponse->toArray(false);
        $this->assertArrayHasKey('id', $messageArray);

        $messageId = $messageArray['id'];
        $this->assertIsString($messageId);

        return $messageId;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testSmokeListMessages(): void
    {
        $response = self::$client->listMessages(self::$threadId);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateMessage
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeRetrieveMessage(string $messageId): void
    {
        $response = self::$client->retrieveMessage(self::$threadId, $messageId);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateMessage
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeModifyMessage(string $messageId): void
    {
        $response = self::$client->modifyMessage(
            self::$threadId,
            $messageId,
            (new ModifyMessagePayloadBuilder())->addMetadata("new_key", "new_value")->getPayload()
        );
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateMessage
     * @depends testSmokeListMessages
     * @depends testSmokeRetrieveMessage
     * @depends testSmokeModifyMessage
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeDeleteMessage(string $messageId): void
    {
        $messageResponse = self::$client->deleteMessage(self::$threadId, $messageId);
        $this->assertSame(200, $messageResponse->getStatusCode());
    }
}