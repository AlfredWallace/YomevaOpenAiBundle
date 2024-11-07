<?php

namespace Yomeva\OpenAiBundle\Model\Content;

class ImageFileContentPart extends ContentPart
{
    public function __construct(
        public ImageFile $imageFile
    ) {
        parent::__construct('image_file');
    }
}