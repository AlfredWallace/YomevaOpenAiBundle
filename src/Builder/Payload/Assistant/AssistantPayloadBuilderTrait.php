<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasResponseFormatTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasSamplingTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolResourcesFullTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsTrait;


trait AssistantPayloadBuilderTrait
{
    use HasMetadataTrait;
    use HasSamplingTrait;
    use HasToolResourcesFullTrait;
    use HasToolsTrait;
    use HasResponseFormatTrait;

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
}