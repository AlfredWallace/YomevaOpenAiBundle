<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;

class CreateAssistantPayloadBuilder extends AssistantPayloadBuilder
{
    public function __construct(string $model)
    {
        $this->assistantPayload = new CreateAssistantPayload($model);
    }
}