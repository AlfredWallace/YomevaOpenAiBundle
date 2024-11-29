<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;
use Yomeva\OpenAiBundle\Model\ToolChoice\BasicToolChoice;
use Yomeva\OpenAiBundle\Model\ToolChoice\ToolChoice;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesSimple;
use Yomeva\OpenAiBundle\Model\TruncationStrategy\TruncationStrategy;

class CreateThreadAndRunPayload extends CreateRunPayloadBase
{
    public function __construct(
        public string $assistantId,
        public ?CreateThreadPayload $thread = null,
        public ?ToolResourcesSimple $toolResources = null,
        public ?string $model = null,
        public ?string $instructions = null,
        public ?array $tools = null,
        public ?float $temperature = null,
        public ?float $topP = null,
        public ?bool $stream = null,
        public ?int $maxPromptTokens = null,
        public ?int $maxCompletionTokens = null,
        public ?TruncationStrategy $truncationStrategy = null,
        public BasicToolChoice|ToolChoice|null $toolChoice = null,
        public ?bool $parallelToolCalls = null,
        public string|ResponseFormat|null $responseFormat = null,
        public ?array $metadata = null
    ) {
        parent::__construct(
            assistantId: $assistantId,
            model: $model,
            instructions: $instructions,
            tools: $tools,
            temperature: $temperature,
            topP: $topP,
            stream: $stream,
            maxPromptTokens: $maxPromptTokens,
            maxCompletionTokens: $maxCompletionTokens,
            truncationStrategy: $truncationStrategy,
            toolChoice: $toolChoice,
            parallelToolCalls: $parallelToolCalls,
            responseFormat: $responseFormat,
            metadata: $metadata
        );
    }
}