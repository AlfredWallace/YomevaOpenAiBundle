<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolResourcesFullTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsTrait;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonObjectResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormatObject;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\TextResponseFormat;


trait AssistantPayloadBuilderTrait
{
    use HasMetadataTrait;
    use HasToolResourcesFullTrait;
    use HasToolsTrait;

    public function setName(string $name): self
    {
        $this->getPayload()->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->getPayload()->description = $description;
        return $this;
    }

    public function setInstructions(string $instructions): self
    {
        $this->getPayload()->instructions = $instructions;
        return $this;
    }

    public function setTemperature(float $temperature): self
    {
        $this->getPayload()->temperature = $temperature;
        return $this;
    }

    public function setTopP(float $topP): self
    {
        $this->getPayload()->topP = $topP;
        return $this;
    }

    public function setResponseFormatToAuto(): self
    {
        $this->getPayload()->responseFormat = ResponseFormat::AUTO;
        return $this;
    }

    public function setResponseFormatToText(): self
    {
        $this->getPayload()->responseFormat = new TextResponseFormat();
        return $this;
    }

    public function setResponseFormatToJsonObject(): self
    {
        $this->getPayload()->responseFormat = new JsonObjectResponseFormat();
        return $this;
    }

    public function setResponseFormatToJsonSchema(
        string $name,
        array $schema,
        ?string $description = null,
        ?bool $strict = null
    ): self {
        $this->getPayload()->responseFormat = new JsonSchemaResponseFormat(
            new JsonSchemaResponseFormatObject($name, $schema, $description, $strict)
        );
        return $this;
    }
}