<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

abstract class Tool
{
    public function __construct(public readonly ToolType $type)
    {
    }
}