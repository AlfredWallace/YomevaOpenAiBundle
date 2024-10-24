<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Yomeva\OpenAiBundle\Model\Tool\Tool;

class FileSearchBasicTool extends Tool
{
    public function __construct()
    {
        parent::__construct('file_search');
    }
}