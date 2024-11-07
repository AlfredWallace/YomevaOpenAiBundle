<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\Tool;
use Yomeva\OpenAiBundle\Model\Tool\ToolType;

#[Assert\Cascade]
class FileSearchTool extends Tool
{
    public function __construct(public ?FileSearchToolOverrides $fileSearch = null)
    {
        parent::__construct(ToolType::FileSearch);
    }
}