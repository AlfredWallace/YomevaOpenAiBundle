<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class ToolResources
{
    public function __construct(

        #[Assert\Valid]
        public ?CodeInterpreterResources $codeInterpreter = null,

        #[Assert\Valid]
        public ?FileSearchResources $fileSearch = null,
    )
    {
    }
}