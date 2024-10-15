<?php

namespace Yomeva\OpenAiBundle\Builder;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
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

    public function addCodeInterpreterTool(): self
    {
        $this->createAssistantPayload->tools[] = new CodeInterpreterTool();
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
        $this->createAssistantPayload->tools[] = new FunctionTool(
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
            $this->createAssistantPayload->tools[] = new FileSearchTool();
            return $this;
        }

        $fileSearch = new FileSearchToolOverrides();

        if ($maxNumResults !== null) {
            $fileSearch->maxNumResults = $maxNumResults;
        }

        if ($scoreThreshold !== null) {
            $fileSearch->rankingOptions = new FileSearchRankingOptions($scoreThreshold, $ranker);
        }

        $this->createAssistantPayload->tools[] = new FileSearchTool($fileSearch);
        return $this;
    }

    /**
     * @param string[] $fileIds
     */
    public function setCodeInterpreterToolResources(array $fileIds): self
    {
        if ($this->createAssistantPayload->toolResources === null) {
            $this->createAssistantPayload->toolResources = new ToolResources();
        }

        $this->createAssistantPayload->toolResources->codeInterpreter = new CodeInterpreterResources($fileIds);
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
        if ($this->createAssistantPayload->toolResources === null) {
            $this->createAssistantPayload->toolResources = new ToolResources();
        }

        $this->createAssistantPayload->toolResources->fileSearch = new FileSearchResources(
            $vectorStoreIds,
            $vectorStores
        );
        return $this;
    }

    public function setMetadata(array $metadata): self
    {
        $this->createAssistantPayload->metadata = $metadata;
        return $this;
    }

    public function addMetadata(string $key, string $value): self
    {
        if ($this->createAssistantPayload->metadata === null) {
            $this->createAssistantPayload->metadata = [];
        }

        $this->createAssistantPayload->metadata[$key] = $value;
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

    public function setResponseFormatToAuto(): self
    {
        $this->createAssistantPayload->responseFormat = ResponseFormat::AUTO;
        return $this;
    }

    public function setResponseFormatToText(): self
    {
        $this->createAssistantPayload->responseFormat = new TextResponseFormat();
        return $this;
    }

    public function setResponseFormatToJsonObject(): self
    {
        $this->createAssistantPayload->responseFormat = new JsonObjectResponseFormat();
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
        $this->createAssistantPayload->responseFormat = new JsonSchemaResponseFormat(
            new JsonSchemaResponseFormatObject($name, $schema, $description, $strict)
        );
        return $this;
    }
}