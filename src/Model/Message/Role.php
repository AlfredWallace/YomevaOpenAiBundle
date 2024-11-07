<?php

namespace Yomeva\OpenAiBundle\Model\Message;

enum Role: string
{
    case User = 'user';
    case Assistant = 'assistant';
}
