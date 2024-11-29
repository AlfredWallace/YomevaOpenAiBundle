<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesFull;

class CreateAssistantPayload extends AssistantPayload
{
    /**
     * @param string $model
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param mixed[]|null $tools
     * @param ToolResourcesFull|null $toolResources
     * @param array<string, string>|null $metadata
     * @param float|null $temperature
     * @param float|null $topP
     * @param string|ResponseFormat|null $responseFormat
     */
    public function __construct(
        public string $model,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $instructions = null,
        public ?array $tools = null,
        public ?ToolResourcesFull $toolResources = null,
        public ?array $metadata = null,
        public ?float $temperature = null,
        public ?float $topP = null,
        public string|ResponseFormat|null $responseFormat = null,
    ) {
        parent::__construct(
            name: $name,
            description: $description,
            instructions: $instructions,
            tools: $tools,
            toolResources: $toolResources,
            metadata: $metadata,
            temperature: $temperature,
            topP: $topP,
            responseFormat: $responseFormat
        );
    }
}