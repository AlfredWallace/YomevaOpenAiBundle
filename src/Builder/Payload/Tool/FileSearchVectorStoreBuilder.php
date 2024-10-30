<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Tool;

use Yomeva\OpenAiBundle\Model\Chunking\AutoChunkingStrategy;
use Yomeva\OpenAiBundle\Model\Chunking\StaticChunkingStrategy;
use Yomeva\OpenAiBundle\Model\Chunking\StaticChunkingStrategyStatic;
use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesVectorStore;

class FileSearchVectorStoreBuilder
{
    private FileSearchResourcesVectorStore $fileSearchResourceStore;

    public function __construct(
        ?array $fileIds = null,
        ?ChunkingStrategy $strategy = null,
        ?int $maxChunkSizeTokens = null,
        ?int $chunkOverlapTokens = null,
        ?array $metadata = null
    ) {
        $chosenStrategy = match ($strategy) {
            ChunkingStrategy::Static => new StaticChunkingStrategy(
                new StaticChunkingStrategyStatic(
                    $maxChunkSizeTokens,
                    $chunkOverlapTokens
                )
            ),
            ChunkingStrategy::Auto => new AutoChunkingStrategy(),
            default => null,
        };

        $this->fileSearchResourceStore = new FileSearchResourcesVectorStore(
            $fileIds,
            $chosenStrategy,
            $metadata
        );
    }

    public function getVectorStore(): FileSearchResourcesVectorStore
    {
        return $this->fileSearchResourceStore;
    }
}