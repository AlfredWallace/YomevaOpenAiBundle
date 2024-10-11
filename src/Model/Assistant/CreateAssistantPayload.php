<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;
use Yomeva\OpenAiBundle\Validator\Metadata;
use Yomeva\OpenAiBundle\Validator\TypedArray;

#[Assert\Cascade]
class CreateAssistantPayload implements PayloadInterface
{
    public function __construct(
        public string $model,

        #[Assert\Length(max: 256)]
        public ?string $name = null,

        #[Assert\Length(max: 512)]
        public ?string $description = null,

        #[Assert\Length(max: 256000)]
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
        public array $tools = [],

        public ?ToolResources $toolResources = null,

        #[Assert\Count(max: 16)]
        #[Metadata]
        public array $metadata = [],

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(2.0)]
        public float $temperature = 1.0,

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(1.0)]
        public float $topP = 1.0,

        public string|ResponseFormat|null $responseFormat = 'auto',
    ) {
    }
}