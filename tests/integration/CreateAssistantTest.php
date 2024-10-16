<?php

declare(strict_types=1);

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Yomeva\OpenAiBundle\Builder\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

class CreateAssistantTest extends TestCase
{
    public function testCreateAssistant(): void
    {
        $openAiClient = new OpenAiClient($_ENV['OPEN_AI_API_KEY']);
        $response = $openAiClient->createAssistant(
            (new CreateAssistantPayloadBuilder('gpt-4o'))
                ->getPayload()
        );

        $this->assertEquals('200', $response->getStatusCode());
    }
}
