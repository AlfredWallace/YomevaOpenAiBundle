<?php

namespace Yomeva\OpenAiBundle\Model\Content;

class ImageUrl
{
    public function __construct(
        public string $url,
        public ?Detail $detail = null,
    ) {
    }
}