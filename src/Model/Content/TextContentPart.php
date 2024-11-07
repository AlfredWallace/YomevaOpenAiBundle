<?php

namespace Yomeva\OpenAiBundle\Model\Content;

class TextContentPart extends ContentPart
{
    public function __construct(
        public string $text,
    ) {
        parent::__construct('text');
    }
}