<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class CodeInterpreterResources
{
    public function __construct(public array $fileIds = [])
    {
    }
}