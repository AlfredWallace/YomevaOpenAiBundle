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
     *
     * To easily build VectorStores, use Yomeva\OpenAiBundle\Builder\Payload\Tool\FileSearchVectorStoreBuilder
     * Example:
     * $openAiClient->createAssistant('gpt-4o')
     *     ...
     *     ->setFileSearchResources(
     *         vectorStores: [
     *             (new FileSearchVectorStoreBuilder())
     *                 ->getVectorStore(),
     *             ...
     *             (new FileSearchVectorStoreBuilder(
     *                 fileIds: ["file-id-3", "file-id-4"],
     *                 strategy: ChunkingStrategy::Static,
     *                 maxChunkSizeTokens: 900,
     *                 chunkOverlapTokens: 300,
     *                 metadata: [
     *                     "foo" => "bar",
     *                     "hello" => "world"
     *                 ]))
     *                 ->getVectorStore(),
     *             ...
     *         ]
     *     )
     *     ...
     *     ->getPayload();
     * @param FileSearchResourcesVectorStore[] $vectorStores
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