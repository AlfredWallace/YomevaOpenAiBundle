<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ToolResources\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesFull;
use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesVectorStore;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesFull;

trait HasToolResourcesFullTrait
{
    abstract public function getPayload(): PayloadInterface;

    /**
     * @param string[] $fileIds
     */
    public function setCodeInterpreterToolResources(array $fileIds): self
    {
        if ($this->getPayload()->toolResources === null) {
            $this->getPayload()->toolResources = new ToolResourcesFull();
        }

        $this->getPayload()->toolResources->codeInterpreter = new CodeInterpreterResources($fileIds);
        return $this;
    }

    /**
     * @param string[] $vectorStoreIds
     *
     * To easily build VectorStores, use Yomeva\OpenAiBundle\Builder\Payload\NestedPayloadBuilders\FileSearchVectorStoreBuilder
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
            $this->getPayload()->toolResources = new ToolResourcesFull();
        }

        $this->getPayload()->toolResources->fileSearch = new FileSearchResourcesFull(
            $vectorStoreIds,
            $vectorStores
        );
        return $this;
    }
}