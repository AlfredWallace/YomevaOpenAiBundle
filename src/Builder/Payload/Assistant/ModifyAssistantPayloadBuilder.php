<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Model\Assistant\ModifyAssistantPayload;

class ModifyAssistantPayloadBuilder extends AssistantPayloadBuilder
{
    public function __construct(?string $model = null)
    {
        $this->assistantPayload = new ModifyAssistantPayload($model);
    }

    public function setModel(string $model): self
    {
        $this->assistantPayload->model = $model;
        return $this;
    }
}