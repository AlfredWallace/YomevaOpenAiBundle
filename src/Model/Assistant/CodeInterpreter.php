<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class CodeInterpreter
{
    public function __construct(public array $fileIds = [])
    {
    }
}