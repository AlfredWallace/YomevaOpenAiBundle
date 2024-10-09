<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

class StaticChunkingStrategy extends ChunkingStrategy
{
    public function __construct(public StaticChunkingStrategyStatic $staticChunkingStrategyStatic)
    {
        parent::__construct('static');
    }
}