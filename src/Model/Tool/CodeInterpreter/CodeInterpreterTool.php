<?php

namespace Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter;

use Yomeva\OpenAiBundle\Model\Tool\Tool;
use Yomeva\OpenAiBundle\Model\Tool\ToolType;

class CodeInterpreterTool extends Tool
{
    public function __construct()
    {
        parent::__construct(ToolType::CodeInterpreter);
    }
}