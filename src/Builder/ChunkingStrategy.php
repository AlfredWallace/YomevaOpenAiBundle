<?php

namespace Yomeva\OpenAiBundle\Builder;

enum ChunkingStrategy: string
{
    case Auto = 'auto';
    case Static = 'static';
}
