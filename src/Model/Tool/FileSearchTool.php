<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FileSearchTool extends Tool
{
    public function __construct(

        #[Assert\Valid]
        public ?FileSearchToolOverrides $fileSearch = null
    )
    {
        parent::__construct('file_search');
    }
}