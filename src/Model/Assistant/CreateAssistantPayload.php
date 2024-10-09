<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;

class CreateAssistantPayload
{
    public function __construct(
        public string $model,

        #[Assert\Length(max: 256)]
        public ?string $name = null,

        #[Assert\Length(max: 512)]
        public ?string $description = null,

        #[Assert\Length(max: 256000)]
        public ?string $instructions = null,

        // TODO : Assert that all array elements are one of the valid types
        public array $tools = [],

        public ?ToolResources $toolResources = null,

        // TODO : Max array length = 16, max key length = 64, max value length = 512
        public array $metadata = [],

        #[Assert\GreaterThanOrEqual(0)]
        #[Assert\LessThanOrEqual(2)]
        public float $temperature = 1,

        #[Assert\GreaterThanOrEqual(0)]
        #[Assert\LessThanOrEqual(1)]
        public float $topP = 1,

        // TODO
        public string|object|null $responseFormat = 'auto',
    )
    {
    }
}