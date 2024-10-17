<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

// TODO: il faut l'aide de Cédrid je n'y arrive pas
class OpenAiClientTest /*extends TestCase */
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     *
     * @dataProvider configDataProvider
     */
    public function testClientConfig(array $options, array $expected): void
    {
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock->withOptions($options);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('toArray')
            ->with(false)
            ->willReturn([]);

        $httpClientMock->method('request')
            ->with('GET', 'models')
            ->willReturn($responseMock);

        $openAiClientMock = $this->getMockBuilder(OpenAiClient::class)
            ->setConstructorArgs(['fake-api-key'])
            ->onlyMethods(['getHttpClient'])
            ->getMock();

        $openAiClientMock->method('getHttpClient')
            ->willReturn($httpClientMock);

        $response = $openAiClientMock->listModels();

        $this->assertEquals($expected, $response->toArray(false));
    }

    public function configDataProvider(): array
    {
        return [
            '200' => [
                'options' => (new HttpOptions())
                    ->setBaseUri('https://api.openai.com/v1/')
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('Authorization', "Bearer fake-api-key")
                    ->setHeader('OpenAI-Beta', 'assistants=v2')
                    ->toArray(),
                'expected' => []
            ],
            'no-authorization' => [
                'options' => (new HttpOptions())
                    ->setBaseUri('https://api.openai.com/v1/')
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('OpenAI-Beta', 'assistants=v2')
                    ->toArray(),
                'expected' => [
                    'error' => [
                        'message' => 'Missing bearer authentication in header',
                        'type' => 'invalid_request_error',
                        'param' => null,
                        'code' => null,
                    ],
                ]
            ]
        ];
    }
}