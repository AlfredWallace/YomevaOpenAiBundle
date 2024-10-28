<?php

namespace Yomeva\OpenAiBundle\Model\Tool\Function;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\Tool;
use Yomeva\OpenAiBundle\Model\Tool\ToolType;

#[Assert\Cascade]
class FunctionTool extends Tool
{
    public function __construct(public FunctionObject $function)
    {
        parent::__construct(ToolType::Function);
    }
}