<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Assistant\AssistantPayload;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonObjectResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormatObject;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\TextResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchRankingOptions;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResources;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResourcesVectorStore;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchToolOverrides;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObject;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;

abstract class AssistantPayloadBuilder implements PayloadBuilderInterface
{
    protected AssistantPayload $assistantPayload;

    public function getPayload(): AssistantPayload
    {
        return $this->assistantPayload;
    }

    public function setName(string $name): self
    {
        $this->assistantPayload->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->assistantPayload->description = $description;
        return $this;
    }

    public function setInstructions(string $instructions): self
    {
        $this->assistantPayload->instructions = $instructions;
        return $this;
    }

    public function addCodeInterpreterTool(): self
    {
        $this->assistantPayload->tools[] = new CodeInterpreterTool();
        return $this;
    }

    public function addFunctionTool(
        string $name,
        ?string $description = null,
        /**
         * OpenAI doc :
         * The parameters the functions accepts, described as a JSON Schema object.
         *
         * See the guide for examples:
         * https://platform.openai.com/docs/guides/function-calling
         *
         * And the JSON Schema reference for documentation about the format :
         * https://json-schema.org/understanding-json-schema
         */
        ?array $parameters = null,
        ?bool $strict = null
    ): self {
        $this->assistantPayload->tools[] = new FunctionTool(
            new FunctionObject(
                $name,
                $description,
                $parameters,
                $strict
            )
        );
        return $this;
    }

    public function addFileSearchTool(
        ?int $maxNumResults = null,
        ?float $scoreThreshold = null,
        ?Ranker $ranker = null
    ): self {
        if ($scoreThreshold === null && $ranker !== null) {
            throw new \InvalidArgumentException('Ranker cannot be set without scoreThreshold.');
        }

        // No options passed
        if ($maxNumResults === null && $scoreThreshold === null) {
            $this->assistantPayload->tools[] = new FileSearchTool();
            return $this;
        }

        $fileSearch = new FileSearchToolOverrides();

        if ($maxNumResults !== null) {
            $fileSearch->maxNumResults = $maxNumResults;
        }

        if ($scoreThreshold !== null) {
            $fileSearch->rankingOptions = new FileSearchRankingOptions($scoreThreshold, $ranker);
        }

        $this->assistantPayload->tools[] = new FileSearchTool($fileSearch);
        return $this;
    }

    /**
     * @param string[] $fileIds
     */
    public function setCodeInterpreterToolResources(array $fileIds): self
    {
        if ($this->assistantPayload->toolResources === null) {
            $this->assistantPayload->toolResources = new ToolResources();
        }

        $this->assistantPayload->toolResources->codeInterpreter = new CodeInterpreterResources($fileIds);
        return $this;
    }

    /**
     * @param string[] $vectorStoreIds
     * @param FileSearchResourcesVectorStore[] $vectorStores
     *
     * Maybe later add a builder for the vector stores inside
     */
    public function setFileSearchResources(array $vectorStoreIds = null, array $vectorStores = null): self
    {
        if ($this->assistantPayload->toolResources === null) {
            $this->assistantPayload->toolResources = new ToolResources();
        }

        $this->assistantPayload->toolResources->fileSearch = new FileSearchResources(
            $vectorStoreIds,
            $vectorStores
        );
        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->assistantPayload->metadata = $metadata;
        return $this;
    }

    public function addMetadata(string $key, string $value): self
    {
        if ($this->assistantPayload->metadata === null) {
            $this->assistantPayload->metadata = [];
        }

        $this->assistantPayload->metadata[$key] = $value;
        return $this;
    }

    public function setTemperature(float $temperature): self
    {
        $this->assistantPayload->temperature = $temperature;
        return $this;
    }

    public function setTopP(float $topP): self
    {
        $this->assistantPayload->topP = $topP;
        return $this;
    }

    public function setResponseFormatToAuto(): self
    {
        $this->assistantPayload->responseFormat = ResponseFormat::AUTO;
        return $this;
    }

    public function setResponseFormatToText(): self
    {
        $this->assistantPayload->responseFormat = new TextResponseFormat();
        return $this;
    }

    public function setResponseFormatToJsonObject(): self
    {
        $this->assistantPayload->responseFormat = new JsonObjectResponseFormat();
        return $this;
    }

    public function setResponseFormatToJsonSchema(
        string $name,
        /**
         * The schema for the response format, described as a JSON Schema object.
         * See: https://json-schema.org/understanding-json-schema
         */
        array $schema,
        ?string $description = null,
        ?bool $strict = null
    ): self {
        $this->assistantPayload->responseFormat = new JsonSchemaResponseFormat(
            new JsonSchemaResponseFormatObject($name, $schema, $description, $strict)
        );
        return $this;
    }
}