<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Assistant;

enum ChunkingStrategy: string
{
    case Auto = 'auto';
    case Static = 'static';
}
