<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class ToolResources
{
    public function __construct(
        public ?CodeInterpreter $codeInterpreter = null,
        public ?FileSearch $fileSearch = null,
    )
    {
    }
}