<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

enum ToolType: string
{
    case CodeInterpreter = 'code_interpreter';
    case FileSearch = 'file_search';
    case Function = 'function';
}
