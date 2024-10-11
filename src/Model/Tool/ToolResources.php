<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterResources;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResources;

#[Assert\Cascade]
#[Assert\Expression(
    "this.codeInterpreter === null and this.fileSearch === null",
    message: "You must provide at least one of the two ToolResources."
)]
class ToolResources
{
    public function __construct(
        public ?CodeInterpreterResources $codeInterpreter = null,

        public ?FileSearchResources $fileSearch = null,
    )
    {
    }
}