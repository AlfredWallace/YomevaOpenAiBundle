<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;
use Yomeva\OpenAiBundle\Model\TruncationStrategy\TruncationStrategy;
use Yomeva\OpenAiBundle\Validator\TypedArray;

abstract class BaseCreateRunPayload extends RunPayload
{
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

        ...$arguments,
    ) {
        parent::__construct(...$arguments);
    }
}