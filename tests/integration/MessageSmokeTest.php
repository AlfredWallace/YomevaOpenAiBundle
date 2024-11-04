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
    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testSmokeCreateMessage(): array
    {

        $threadResponse = self::$client->createThread(
            (new CreateThreadPayloadBuilder())->getPayload()
        );
        $this->assertSame(200, $threadResponse->getStatusCode());

        $threadArray = $threadResponse->toArray(false);
        $this->assertArrayHasKey('id', $threadArray);

        $threadId = $threadArray['id'];
        $this->assertIsString($threadId);

        $messageResponse = self::$client->createMessage(
            $threadId,
            (new CreateMessagePayloadBuilder(Role::User, "Simple message"))->getPayload()
        );
        $this->assertSame(200, $messageResponse->getStatusCode());

        $messageArray = $messageResponse->toArray(false);
        $this->assertArrayHasKey('id', $messageArray);

        $messageId = $messageArray['id'];
        $this->assertIsString($messageId);

        return [$threadId, $messageId];
    }

    /**
     * @depends testSmokeCreateMessage
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeListMessages(array $data): void
    {
        [$threadId, $messageId] = $data;
        $response = self::$client->listMessages($threadId);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateMessage
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeRetrieveMessage(array $data): void
    {
        [$threadId, $messageId] = $data;
        $response = self::$client->retrieveMessage($threadId, $messageId);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateMessage
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeModifyMessage(array $data): void
    {
        [$threadId, $messageId] = $data;
        $response = self::$client->modifyMessage(
            $threadId,
            $messageId,
            (new ModifyMessagePayloadBuilder())->addMetadata("new_key","new_value")->getPayload()
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
    public function testSmokeDeleteMessage(array $data): void
    {
        [$threadId, $messageId] = $data;
        $messageResponse = self::$client->deleteMessage($threadId, $messageId);
        $this->assertSame(200, $messageResponse->getStatusCode());

        $threadResponse = self::$client->deleteThread($threadId);
        $this->assertSame(200, $threadResponse->getStatusCode());
    }
}