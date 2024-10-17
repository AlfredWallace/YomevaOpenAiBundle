<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Yomeva\OpenAiBundle\Builder\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

class CreateAssistantTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testCreateBasicAssistant(): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('toArray')
            ->with(false)
            ->willReturn([
                'id' => 'fake-id',
            ]);

        $httpClientMock->method('request')
            ->with('POST', 'assistants')
            ->willReturn($responseMock);

        $openAiClient = new OpenAiClient('fake-key', $httpClientMock);

        $response = $openAiClient->createAssistant(
            (new CreateAssistantPayloadBuilder('gpt-4o'))->getPayload()
        );

        $this->assertEquals(
            expected: [
                'id' => 'fake-id',
            ],
            actual: $response->toArray(false)
        );
    }
}