<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Tool;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResources;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResourcesVectorStore;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;

trait HasToolResourcesTrait
{
    abstract public function getPayload(): PayloadInterface;

    /**
     * @param string[] $fileIds
     */
    public function setCodeInterpreterToolResources(array $fileIds): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResources();
        }

        $this->getPayload()->toolResources->codeInterpreter = new CodeInterpreterResources($fileIds);
        return $this;
    }

    /**
     * @param string[] $vectorStoreIds
     * @param FileSearchResourcesVectorStore[] $vectorStores
     *
     * Maybe later add a builder for the vector stores inside
     */
    public function setFileSearchResources(array $vectorStoreIds = null, array $vectorStores = null): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResources();
        }

        $this->getPayload()->toolResources->fileSearch = new FileSearchResources(
            $vectorStoreIds,
            $vectorStores
        );
        return $this;
    }
}