<?php

namespace Yomeva\OpenAiBundle\Model\Content;

class ImageUrlContentPart extends ContentPart
{
    public function __construct(
        public ImageUrl $imageUrl,
    ) {
        parent::__construct('image_url');
    }
}