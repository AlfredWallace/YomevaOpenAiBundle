<?php

namespace Yomeva\OpenAiBundle\Builder;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\Tool;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;

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

    public function setName(string $name): self
    {
        $this->createAssistantPayload->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->createAssistantPayload->description = $description;
        return $this;
    }

    public function setInstructions(string $instructions): self
    {
        $this->createAssistantPayload->instructions = $instructions;
        return $this;
    }

    public function addTool(Tool $tool): self
    {
        $this->createAssistantPayload->tools[] = $tool;
        return $this;
    }

    /**
     * @param Tool[] $tools
     */
    public function setTools(array $tools): self
    {
        foreach ($tools as $tool) {
            $this->addTool($tool);
        }
        return $this;
    }

    public function setToolResources(ToolResources $toolResources): self
    {
        $this->createAssistantPayload->toolResources = $toolResources;
        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->createAssistantPayload->metadata = $metadata;
        return $this;
    }

    public function setTemperature(float $temperature): self
    {
        $this->createAssistantPayload->temperature = $temperature;
        return $this;
    }

    public function setTopP(float $topP): self
    {
        $this->createAssistantPayload->topP = $topP;
        return $this;
    }

    public function setResponseFormat(string|ResponseFormat $responseFormat): self
    {
        $this->createAssistantPayload->responseFormat = $responseFormat;
        return $this;
    }
}