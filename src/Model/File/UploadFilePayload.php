<?php

namespace Yomeva\OpenAiBundle\Model\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFilePayload
{
    public function __construct(
        public string $purpose,
        public UploadedFile $uploadedFile,
    )
    {
    }
}