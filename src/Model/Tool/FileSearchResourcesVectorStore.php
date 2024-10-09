<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Yomeva\OpenAiBundle\Model\Chunking\ChunkingStrategy;

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