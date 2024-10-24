<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasToolResourcesInterface;
use Yomeva\OpenAiBundle\Model\Assistant\AssistantPayload;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

interface AssistantPayloadBuilderInterface extends PayloadBuilderInterface, HasMetadataInterface, HasToolResourcesInterface
{
    public function getPayload(): AssistantPayload;

    public function setName(string $name): self;

    public function setDescription(string $description): self;

    public function setInstructions(string $instructions): self;

    public function addCodeInterpreterTool(): self;

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

    public function setResponseFormatToJsonSchema(
        string $name,
        array $schema,
        ?string $description = null,
        ?bool $strict = null
    ): self;
}