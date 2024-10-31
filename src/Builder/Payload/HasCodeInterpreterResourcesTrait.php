<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ToolResources\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesFull;

trait HasCodeInterpreterResourcesTrait
{
    abstract public function getPayload(): PayloadInterface;

    /**
     * @inheritDoc
     */
    public function setCodeInterpreterToolResources(array $fileIds): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResourcesFull();
        }

        $this->getPayload()->toolResources->codeInterpreter = new CodeInterpreterResources($fileIds);
        return $this;
    }
}