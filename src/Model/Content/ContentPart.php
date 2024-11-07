<?php

namespace Yomeva\OpenAiBundle\Model\Content;

abstract class ContentPart
{
    public function __construct(
        public string $type
    ) {
    }
}