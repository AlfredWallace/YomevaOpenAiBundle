<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesVectorStore;

interface HasFileSearchResourcesFullInterface
{
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
    public function setFileSearchResources(array $vectorStoreIds = null, array $vectorStores = null): self;
}