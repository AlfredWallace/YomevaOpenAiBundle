<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsTrait;

trait CreateRunBasePayloadBuilderTrait
{
    use HasMetadataTrait;
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
}