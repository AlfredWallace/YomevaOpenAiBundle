<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

class ChunkingStrategy
{
    public function __construct(
        public string $type = ''
    )
    {
    }
}