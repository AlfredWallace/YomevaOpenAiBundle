<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasResponseFormatInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasSamplingInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolResourcesFullInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsInterface;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Assistant\AssistantPayload;

interface AssistantPayloadBuilderInterface
    extends PayloadBuilderInterface,
            HasMetadataInterface,
            HasToolResourcesFullInterface,
            HasToolsInterface,
            HasSamplingInterface,
            HasResponseFormatInterface
{
    public function getPayload(): AssistantPayload;

    public function setName(string $name): self;

    public function setDescription(string $description): self;

    public function setInstructions(string $instructions): self;

    public function setResponseFormatToAuto(): self;

    public function setResponseFormatToText(): self;

    public function setResponseFormatToJsonObject(): self;

    /**
     * @param string $name
     *
     * The parameters the functions accepts, described as a JSON Schema object.
     * See the guide for examples: https://platform.openai.com/docs/guides/function-calling
     * And the JSON Schema reference for documentation about the format: https://json-schema.org/understanding-json-schema
     * @param array<string, mixed> $schema
     *
     * @param string|null $description
     *
     * @param bool|null $strict
     *
     * @return AssistantPayloadBuilderInterface
     */
    public function setResponseFormatToJsonSchema(
        string $name,
        array $schema,
        ?string $description = null,
        ?bool $strict = null
    ): self;
}