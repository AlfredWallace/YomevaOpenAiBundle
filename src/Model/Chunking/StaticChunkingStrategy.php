<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
class StaticChunkingStrategy extends ChunkingStrategy
{
    public function __construct(public StaticChunkingStrategyStatic $static)
    {
        parent::__construct('static');
    }
}