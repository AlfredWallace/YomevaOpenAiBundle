<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

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