<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;

trait CreateRunBasePayloadBuilderTrait
{
    use HasMetadataTrait;

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
}