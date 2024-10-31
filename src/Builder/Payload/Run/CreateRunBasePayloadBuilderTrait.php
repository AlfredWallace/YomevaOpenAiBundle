<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasSamplingTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsTrait;
use Yomeva\OpenAiBundle\Model\Tool\ToolType;
use Yomeva\OpenAiBundle\Model\ToolChoice\BasicToolChoice;
use Yomeva\OpenAiBundle\Model\ToolChoice\ToolChoice;
use Yomeva\OpenAiBundle\Model\ToolChoice\ToolChoiceFunction;
use Yomeva\OpenAiBundle\Model\TruncationStrategy\TruncationStrategy;
use Yomeva\OpenAiBundle\Model\TruncationStrategy\TruncationStrategyType;

trait CreateRunBasePayloadBuilderTrait
{
    use HasMetadataTrait;
    use HasSamplingTrait;
    use HasToolsTrait;

    public function setModel(string $model): self
    {
        $this->getPayload()->model = $model;
        return $this;
    }

    public function setInstructions(string $instructions): self
    {
        $this->getPayload()->instructions = $instructions;
        return $this;
    }

    public function setStream(bool $stream): self
    {
        $this->getPayload()->stream = $stream;
        return $this;
    }

    public function setMaxPromptTokens(int $maxPromptTokens): self
    {
        $this->getPayload()->maxPromptTokens = $maxPromptTokens;
        return $this;
    }

    public function setMaxCompletionTokens(int $maxCompletionTokens): self
    {
        $this->getPayload()->maxCompletionTokens = $maxCompletionTokens;
        return $this;
    }

    public function setTruncationStrategyToAuto(): self
    {
        $this->getPayload()->truncationStrategy = new TruncationStrategy();
        return $this;
    }

    public function setTruncationStrategyToLastMessages(int $lastMessages): self
    {
        $this->getPayload()->truncationStrategy = new TruncationStrategy(
            TruncationStrategyType::LastMessages,
            $lastMessages
        );
        return $this;
    }

    public function setToolChoiceToNone(): self
    {
        $this->getPayload()->toolChoice = BasicToolChoice::None;
        return $this;
    }

    public function setToolChoiceToAuto(): self
    {
        $this->getPayload()->toolChoice = BasicToolChoice::Auto;
        return $this;
    }

    public function setToolChoiceToRequired(): self
    {
        $this->getPayload()->toolChoice = BasicToolChoice::Required;
        return $this;
    }

    public function setToolChoiceToCodeInterpreter(): self
    {
        $this->getPayload()->toolChoice = new ToolChoice(ToolType::CodeInterpreter);
        return $this;
    }

    public function setToolChoiceToFileSearch(): self
    {
        $this->getPayload()->toolChoice = new ToolChoice(ToolType::FileSearch);
        return $this;
    }

    public function setToolChoiceToFunction(string $functionName): self
    {
        $this->getPayload()->toolChoice = new ToolChoice(
            ToolType::Function,
            new ToolChoiceFunction($functionName)
        );
        return $this;
    }

    public function setParallelToolCalls(bool $parallelToolCalls): self
    {
        $this->getPayload()->parallelToolCalls = $parallelToolCalls;
        return $this;
    }
}