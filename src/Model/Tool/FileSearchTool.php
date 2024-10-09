<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

class FileSearchTool extends Tool
{
    public function __construct(public ?FileSearchToolOverrides $fileSearch = null)
    {
        parent::__construct('file_search');
    }
}