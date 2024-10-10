<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
class FileSearchTool extends Tool
{
    public function __construct(public ?FileSearchToolOverrides $fileSearch = null)
    {
        parent::__construct('file_search');
    }
}