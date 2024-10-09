<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

interface ChunkingStrategyInterface
{
    public function getType(): string;
}