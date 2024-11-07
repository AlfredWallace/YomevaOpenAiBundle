<?php

namespace Yomeva\OpenAiBundle\Model\ToolChoice;

enum BasicToolChoice: string
{
    case None  = 'none';
    case Auto  = 'auto';
    case Required  = 'required';
}
