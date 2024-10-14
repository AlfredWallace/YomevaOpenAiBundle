<?php

namespace Yomeva\OpenAiBundle\Builder;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;

class CreateAssistantPayloadBuilder implements PayloadBuilderInterface
{
    private CreateAssistantPayload $createAssistantPayload;

    public function __construct(string $model)
    {
        $this->createAssistantPayload = new CreateAssistantPayload($model);
    }

    public function getPayload(): CreateAssistantPayload
    {
        return $this->createAssistantPayload;
    }

    public function addName(string $name): self
    {
        $this->createAssistantPayload->name = $name;
        return $this;
    }

    public function addDescription(string $description): self
    {
        $this->createAssistantPayload->description = $description;
        return $this;
    }
}