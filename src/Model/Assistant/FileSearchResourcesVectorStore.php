<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class FileSearchResourcesVectorStore
{
    public function __construct(
        public array $fileIds = [],
        public ?ChunkingStrategy $chunkingStrategy = null,
        public array $metadata = []
    )
    {
    }
}