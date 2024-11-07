<?php

namespace Yomeva\OpenAiBundle\Model\TruncationStrategy;

enum TruncationStrategyType: string
{
    case Auto = 'auto';
    case LastMessages = 'last_messages';
}
