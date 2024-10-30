<?php

namespace Yomeva\OpenAiBundle\Model\ToolChoice;

class ToolChoiceFunction
{
    public function __construct(
        public string $name,
    ) {
    }
}