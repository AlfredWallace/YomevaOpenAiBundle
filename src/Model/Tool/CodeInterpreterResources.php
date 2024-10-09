<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

class CodeInterpreterResources
{
    public function __construct(public array $fileIds = [])
    {
    }
}