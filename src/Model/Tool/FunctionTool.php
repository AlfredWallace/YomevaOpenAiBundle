<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
class FunctionTool extends Tool
{
    public function __construct(public FunctionObject $function)
    {
        parent::__construct('function');
    }
}