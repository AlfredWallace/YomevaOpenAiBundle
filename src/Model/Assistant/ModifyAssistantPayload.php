<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class ModifyAssistantPayload extends AssistantPayload
{
    public function __construct(
        public ?string $model = null,
        ...$arguments
    ) {
        parent::__construct(...$arguments);
    }
}