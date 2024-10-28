<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Yomeva\OpenAiBundle\Model\Tool\Tool;
use Yomeva\OpenAiBundle\Model\Tool\ToolType;

class FileSearchBasicTool extends Tool
{
    public function __construct()
    {
        parent::__construct(ToolType::FileSearch);
    }
}