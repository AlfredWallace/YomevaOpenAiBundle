<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolResourcesInterface;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Assistant\AssistantPayload;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

interface AssistantPayloadBuilderInterface extends PayloadBuilderInterface, HasMetadataInterface, HasToolResourcesInterface
{
    public function getPayload(): AssistantPayload;

    public function setName(string $name): self;

    public function setDescription(string $description): self;

    public function setInstructions(string $instructions): self;

    public function addCodeInterpreterTool(): self;

    /**
     * @param string $name
     *
     * @param string|null $description
     *
     *  The parameters the functions accepts, described as a JSON Schema object.
     *  See the guide for examples: https://platform.openai.com/docs/guides/function-calling
     *  And the JSON Schema reference for documentation about the format: https://json-schema.org/understanding-json-schema
     * @param array|null $parameters
     *
     * @param bool|null $strict
     *
     * @return AssistantPayloadBuilderInterface
     */
    public function addFunctionTool(
        string $name,
        ?string $description = null,
        ?array $parameters = null,
        ?bool $strict = null
    ): self;

    public function addFileSearchTool(
        ?int $maxNumResults = null,
        ?float $scoreThreshold = null,
        ?Ranker $ranker = null
    ): self;

    public function setTemperature(float $temperature): self;

    public function setTopP(float $topP): self;

    public function setResponseFormatToAuto(): self;

    public function setResponseFormatToText(): self;

    public function setResponseFormatToJsonObject(): self;

    /**
     * @param string $name
     *
     * The parameters the functions accepts, described as a JSON Schema object.
     * See the guide for examples: https://platform.openai.com/docs/guides/function-calling
     * And the JSON Schema reference for documentation about the format: https://json-schema.org/understanding-json-schema
     * @param array $schema
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