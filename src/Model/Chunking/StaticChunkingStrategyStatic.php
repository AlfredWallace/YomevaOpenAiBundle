<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

class StaticChunkingStrategyStatic
{
    public function __construct(
        public int $maxChunkSizeTokens = 800,
        public int $chunkOverlapTokens = 400,
    )
    {
    }
}