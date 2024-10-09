<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class CreateAssistantPayload
{
    public function __construct(
        public string $model,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $instructions = null,
        public array $tools = [],
        public ?ToolResources $toolResources = null,
        public array $metadata = [],
        /**
         * Not implemented :
         * - temperature
         * - topP
         * - responseFormat
         */
    )
    {
    }
}