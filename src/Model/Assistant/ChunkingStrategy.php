<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class ChunkingStrategy
{
    public function __construct(
        public string $type = ''
    )
    {
    }
}