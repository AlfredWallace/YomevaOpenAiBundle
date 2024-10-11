<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResources;

#[Assert\Cascade]
class ToolResources
{
    public function __construct(
        public ?CodeInterpreterResources $codeInterpreter = null,

        public ?FileSearchResources $fileSearch = null,
    )
    {
    }
}