<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Tool;

enum ChunkingStrategy: string
{
    case Auto = 'auto';
    case Static = 'static';
}
