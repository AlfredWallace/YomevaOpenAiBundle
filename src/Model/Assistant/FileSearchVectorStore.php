<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class FileSearchVectorStore
{
    public function __construct(
        public array $fileIds = [],
        public ?ChunkingStrategy $chunkingStrategy = null,
        public array $metadata = []
    )
    {
    }
}