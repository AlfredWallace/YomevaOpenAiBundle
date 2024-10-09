<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

class ToolResources
{
    public function __construct(
        public ?CodeInterpreterResources $codeInterpreter = null,
        public ?FileSearchResources $fileSearch = null,
    )
    {
    }
}