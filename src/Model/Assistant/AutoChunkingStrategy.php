<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class AutoChunkingStrategy extends ChunkingStrategy
{
    public function __construct()
    {
        parent::__construct('auto');
    }
}