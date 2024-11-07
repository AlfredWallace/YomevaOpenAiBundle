<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Model\Assistant\ModifyAssistantPayload;

class ModifyAssistantPayloadBuilder implements AssistantPayloadBuilderInterface
{
    use AssistantPayloadBuilderTrait;

    private ModifyAssistantPayload $modifyAssistantPayload;

    public function __construct(?string $model = null)
    {
        $this->modifyAssistantPayload = new ModifyAssistantPayload($model);
    }

    public function getPayload(): ModifyAssistantPayload
    {
        return $this->modifyAssistantPayload;
    }

    public function setModel(string $model): self
    {
        $this->modifyAssistantPayload->model = $model;
        return $this;
    }
}