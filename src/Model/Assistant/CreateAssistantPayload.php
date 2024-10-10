<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FunctionTool;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;

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
        #[Assert\Choice(
            choices: [
                CodeInterpreterTool::class,
                FileSearchTool::class,
                FunctionTool::class
            ],
            multiple: true
        )]
        public array $tools = [],

        public ?ToolResources $toolResources = null,

        // TODO : Max array length = 16, max key length = 64, max value length = 512
        public array $metadata = [],

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(2.0)]
        public float $temperature = 1.0,

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(1.0)]
        public float $topP = 1.0,

        // TODO
        public string|object|null $responseFormat = 'auto',
    ) {
    }
}