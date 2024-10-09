<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class StaticChunkingStrategyStatic
{
    public function __construct(
        public int $maxChunkSizeTokens = 800,
        public int $chunkOverlapTokens = 400,
    )
    {
    }
}