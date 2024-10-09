<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

class CodeInterpreterTool extends Tool
{
    public function __construct()
    {
        parent::__construct('code_interpreter');
    }
}