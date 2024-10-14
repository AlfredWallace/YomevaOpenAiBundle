<?php

namespace Yomeva\OpenAiBundle\Builder;

use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchRankingOptions;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchToolOverrides;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObject;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObjectParameter;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObjectParametersCollection;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;
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

    public function addCodeInterpreterTool(): self
    {
        $this->createAssistantPayload->tools[] = new CodeInterpreterTool();
        return $this;
    }

    /**
     * @param FunctionObjectParameter[] $parameters
     */
    public function addFunctionTool(
        string $name,
        ?string $description = null,
        ?array $parameters = null,
        ?array $required = null,
        ?bool $strict = null
    ): self {
        $functionTool = new FunctionTool(
            new FunctionObject(
                name: $name,
                description: $description,
                strict: $strict
            )
        );

        if ($parameters !== null) {
            $functionTool->function->parameters = new FunctionObjectParametersCollection(
                $parameters,
                $required
            );
        }

        $this->createAssistantPayload->tools[] = $functionTool;
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