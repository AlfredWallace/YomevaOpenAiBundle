<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Builder\Payload\Assistant\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\ModifyAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Run\CreateRunPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Run\CreateThreadAndRunPayloadBuilder;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchRankingOptions;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchToolOverrides;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObject;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;

trait HasToolsTrait
{
    abstract public function getPayload(): PayloadInterface;

    public function addCodeInterpreterTool(): self
    {
        $this->getPayload()->tools[] = new CodeInterpreterTool();
        return $this;
    }

    /**
     * @param string $name
     * @param string|null $description
     * @param array<string, mixed>|null $parameters
     * @param bool|null $strict
     */
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
}