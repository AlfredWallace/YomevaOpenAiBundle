<?php

namespace Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter;

use Yomeva\OpenAiBundle\Model\Tool\Tool;

class CodeInterpreterTool extends Tool
{
    public function __construct()
    {
        parent::__construct('code_interpreter');
    }
}