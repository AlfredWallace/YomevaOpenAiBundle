<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;

class CreateAssistantPayloadBuilder implements AssistantPayloadBuilder
{
    use AssistantPayloadBuilderTrait;

    private CreateAssistantPayload $createAssistantPayload;

    public function __construct(string $model)
    {
        $this->createAssistantPayload = new CreateAssistantPayload($model);
    }

    public function getPayload(): CreateAssistantPayload
    {
        return $this->createAssistantPayload;
    }
}