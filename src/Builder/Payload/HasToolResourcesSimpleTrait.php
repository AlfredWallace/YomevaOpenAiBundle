<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ToolResources\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesSimple;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesSimple;

trait HasToolResourcesSimpleTrait
{
    abstract public function getPayload(): PayloadInterface;

    /**
     * @inheritDoc
     */
    public function setCodeInterpreterToolResources(array $fileIds): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResourcesSimple();
        }

        $this->getPayload()->toolResources->codeInterpreter = new CodeInterpreterResources($fileIds);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFileSearchResources(array $vectorStoreIds): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResourcesSimple();
        }

        $this->getPayload()->toolResources->fileSearch = new FileSearchResourcesSimple($vectorStoreIds);
        return $this;
    }
}