<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

class ToolResourcesSimple extends ToolResourcesBase
{
    public function __construct(
        ?CodeInterpreterResources $codeInterpreter = null,
        ?FileSearchResourcesSimple $fileSearch = null,
    ) {
        parent::__construct($codeInterpreter, $fileSearch);
    }
}