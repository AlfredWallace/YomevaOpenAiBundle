<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class ToolResources
{
    public function __construct(
        public ?CodeInterpreterResources $codeInterpreter = null,
        public ?FileSearchResources $fileSearch = null,
    )
    {
    }
}