<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesSimple;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesSimple;

trait HasFileSearchResourcesSimpleTrait
{
    abstract public function getPayload(): PayloadInterface;

    public function setFileSearchResources(array $vectorStoreIds = null): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResourcesSimple();
        }

        $this->getPayload()->toolResources->fileSearch = new FileSearchResourcesSimple($vectorStoreIds);
        return $this;
    }
}