<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasResponseFormatInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasSamplingInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsInterface;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;

interface CreateRunBasePayloadBuilderInterface
    extends PayloadBuilderInterface,
            HasMetadataInterface,
            HasToolsInterface,
            HasSamplingInterface,
            HasResponseFormatInterface
{
    public function setModel(string $model): self;

    public function setInstructions(string $instructions): self;

    public function setStream(bool $stream): self;

    public function setMaxPromptTokens(int $maxPromptTokens): self;

    public function setMaxCompletionTokens(int $maxCompletionTokens): self;

    public function setTruncationStrategyToAuto(): self;

    public function setTruncationStrategyToLastMessages(int $lastMessages): self;

    public function setToolChoiceToNone(): self;

    public function setToolChoiceToAuto(): self;

    public function setToolChoiceToRequired(): self;

    public function setToolChoiceToCodeInterpreter(): self;

    public function setToolChoiceToFileSearch(): self;

    public function setToolChoiceToFunction(string $functionName): self;

    public function setParallelToolCalls(bool $parallelToolCalls): self;
}