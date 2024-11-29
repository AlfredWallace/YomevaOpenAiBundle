<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;
use Yomeva\OpenAiBundle\Model\ToolChoice\BasicToolChoice;
use Yomeva\OpenAiBundle\Model\ToolChoice\ToolChoice;
use Yomeva\OpenAiBundle\Model\TruncationStrategy\TruncationStrategy;
use Yomeva\OpenAiBundle\Validator\TypedArray;

abstract class CreateRunPayloadBase extends RunPayload
{
    /**
     * @param string $assistantId
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
        public ?string $model = null,
        public ?string $instructions = null,

        #[Assert\Count(max: 128)]
        #[Assert\All([new Assert\NotBlank()])]
        #[TypedArray(
            [
                CodeInterpreterTool::class,
                FileSearchTool::class,
                FunctionTool::class
            ]
        )]
        public ?array $tools = null,

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(2.0)]
        public ?float $temperature = null,

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(1.0)]
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
        parent::__construct($metadata);
    }
}