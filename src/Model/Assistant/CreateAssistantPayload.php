<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class CreateAssistantPayload extends AssistantPayload
{
    public function __construct(
        public string $model,
        ...$arguments
    ) {
        parent::__construct(...$arguments);
    }
}