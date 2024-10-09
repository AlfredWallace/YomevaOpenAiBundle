<?php

namespace Yomeva\OpenAiBundle\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class UploadFilePayload
{
    public function __construct(
        public string $purpose,
        public UploadedFile $uploadedFile,
    )
    {
    }
}