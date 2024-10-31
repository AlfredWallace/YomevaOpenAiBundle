<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesFull;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesFull;

trait HasFileSearchResourcesFullTrait
{
    /**
     * @inheritDoc
     */
    public function setFileSearchResources(array $vectorStoreIds = null, array $vectorStores = null): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResourcesFull();
        }

        $this->getPayload()->toolResources->fileSearch = new FileSearchResourcesFull(
            $vectorStoreIds,
            $vectorStores
        );
        return $this;
    }
}