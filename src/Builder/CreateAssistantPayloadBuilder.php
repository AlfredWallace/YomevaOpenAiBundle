<?php

namespace Yomeva\OpenAiBundle\Builder;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;

class CreateAssistantPayloadBuilder
{
    private CreateAssistantPayload $createAssistantPayload;

    private function setPayload(CreateAssistantPayload $createAssistantPayload): void
    {
        $this->createAssistantPayload = $createAssistantPayload;
    }

    public static function make(string $model): CreateAssistantPayloadBuilder
    {
        $builder = new CreateAssistantPayloadBuilder();
        $builder->setPayload(new CreateAssistantPayload($model));
        return $builder;
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