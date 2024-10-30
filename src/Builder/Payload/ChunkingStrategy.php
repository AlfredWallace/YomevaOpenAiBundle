<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

enum ChunkingStrategy: string
{
    case Auto = 'auto';
    case Static = 'static';
}
