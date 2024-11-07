<?php

namespace Yomeva\OpenAiBundle\Model\Content;

class ImageFile
{
    public function __construct(
        /**
         * The File ID of the image in the message content.
         * Set purpose="vision" when uploading the File if you need to later display the file content.
         */
        public string $fileId,
        public ?Detail $detail = null,
    ) {
    }
}