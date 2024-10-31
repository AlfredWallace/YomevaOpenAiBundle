<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolsInterface;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;

interface CreateRunBasePayloadBuilderInterface extends PayloadBuilderInterface, HasMetadataInterface, HasToolsInterface
{
    public function setModel(string $model): self;

    public function setInstructions(string $instructions): self;
}