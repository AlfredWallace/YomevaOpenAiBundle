<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Run\CreateRunPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\CreateThreadPayloadBuilder;

class RunSmokeTest extends ClientTestCase
{
    private static string $assistantId;
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

        $assistantResponse = self::$client->createAssistant(
            (new CreateAssistantPayloadBuilder('gpt-4o'))
                ->setInstructions("You're a basic assistant that just say hello and nice things.")
                ->getPayload()
        );
        self::$assistantId = $assistantResponse->toArray(false)['id'];

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

        $assistantResponse = self::$client->deleteAssistant(self::$assistantId);
        $assistantResponse->toArray(false);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSmokeCreateRun(): string
    {
        $response = self::$client->createRun(
            self::$threadId,
            (new CreateRunPayloadBuilder(self::$assistantId))->getPayload()
        );
        $this->assertSame(200, $response->getStatusCode());
        $responseArray = $response->toArray(false);
        $this->assertArrayHasKey('id', $responseArray);
        $id = $responseArray['id'];
        $this->assertIsString($id);

        return $id;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testSmokeListRuns(): void
    {
        $response = self::$client->listRuns(self::$threadId);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @depends testSmokeCreateRun
     *
     * @throws TransportExceptionInterface
     */
    public function testSmokeRetrieveRun(string $runId): void
    {
        $response = self::$client->retrieveRun(self::$threadId, $runId);
        $this->assertSame(200, $response->getStatusCode());
    }

    // todo: modify or cancel a run, but it's not that simple because you have to prevent the run from completing

    // todo but maybe not that necessary: test createThreadAndRun
}