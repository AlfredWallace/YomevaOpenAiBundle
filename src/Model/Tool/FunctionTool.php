<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FunctionTool extends Tool
{
    public function __construct(

        #[Assert\Valid]
        public FunctionObject $function
    )
    {
        parent::__construct('function');
    }
}