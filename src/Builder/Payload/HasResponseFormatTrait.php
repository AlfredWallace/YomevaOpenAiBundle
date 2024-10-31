<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonObjectResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormatObject;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\TextResponseFormat;

trait HasResponseFormatTrait
{
    abstract public function getPayload(): PayloadInterface;

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