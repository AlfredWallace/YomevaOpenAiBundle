<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

class AutoChunkingStrategy extends ChunkingStrategy
{
    public function __construct()
    {
        parent::__construct('auto');
    }
}