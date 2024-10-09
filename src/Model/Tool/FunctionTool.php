<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

class FunctionTool extends Tool
{
    public function __construct(public FunctionObject $function)
    {
        parent::__construct('function');
    }
}