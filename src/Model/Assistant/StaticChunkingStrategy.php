<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

use Yomeva\OpenAiBundle\Model\Assistant\ChunkingStrategy;

class StaticChunkingStrategy extends ChunkingStrategy
{
    public function __construct(
        public StaticChunkingStrategyStatic $staticChunkingStrategyStatic,
    )
    {
        parent::__construct('static');
    }
}