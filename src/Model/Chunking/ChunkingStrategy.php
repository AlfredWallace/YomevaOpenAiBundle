<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

abstract class ChunkingStrategy
{
    public function __construct(public readonly string $type)
    {
    }
}