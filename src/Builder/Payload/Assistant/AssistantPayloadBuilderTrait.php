<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolResourcesFullTrait;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonObjectResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormatObject;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\TextResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchRankingOptions;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchToolOverrides;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObject;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;


trait AssistantPayloadBuilderTrait
{
    use HasMetadataTrait;
    use HasToolResourcesFullTrait;

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

    public function addCodeInterpreterTool(): self
    {
        $this->getPayload()->tools[] = new CodeInterpreterTool();
        return $this;
    }

    public function addFunctionTool(
        string $name,
        ?string $description = null,
        ?array $parameters = null,
        ?bool $strict = null
    ): self {
        $this->getPayload()->tools[] = new FunctionTool(
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
            $this->getPayload()->tools[] = new FileSearchTool();
            return $this;
        }

        $fileSearch = new FileSearchToolOverrides();

        if ($maxNumResults !== null) {
            $fileSearch->maxNumResults = $maxNumResults;
        }

        if ($scoreThreshold !== null) {
            $fileSearch->rankingOptions = new FileSearchRankingOptions($scoreThreshold, $ranker);
        }

        $this->getPayload()->tools[] = new FileSearchTool($fileSearch);
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