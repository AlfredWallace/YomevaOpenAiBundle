<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

class ToolResourcesFull extends ToolResourcesBase
{
    public function __construct(
        ?CodeInterpreterResources $codeInterpreter = null,
        ?FileSearchResourcesFull $fileSearch = null,
    ) {
        parent::__construct($codeInterpreter, $fileSearch);
    }
}