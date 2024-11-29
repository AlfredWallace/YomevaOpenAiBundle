<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\ToolChoice\BasicToolChoice;
use Yomeva\OpenAiBundle\Model\ToolChoice\ToolChoice;
use Yomeva\OpenAiBundle\Model\TruncationStrategy\TruncationStrategy;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateRunPayload extends CreateRunPayloadBase
{
    /**
     * @param string $assistantId
     * @param string|null $additionalInstructions
     * @param CreateMessagePayload[]|null $additionalMessages
     * @param string|null $model
     * @param string|null $instructions
     * @param mixed[]|null $tools
     * @param float|null $temperature
     * @param float|null $topP
     * @param bool|null $stream
     * @param int|null $maxPromptTokens
     * @param int|null $maxCompletionTokens
     * @param TruncationStrategy|null $truncationStrategy
     * @param BasicToolChoice|ToolChoice|null $toolChoice
     * @param bool|null $parallelToolCalls
     * @param string|ResponseFormat|null $responseFormat
     * @param array<string, string>|null $metadata
     */
    public function __construct(
        public string $assistantId,
        public ?string $additionalInstructions = null,

        #[TypedArray([CreateMessagePayload::class])]
        public ?array $additionalMessages = null,

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