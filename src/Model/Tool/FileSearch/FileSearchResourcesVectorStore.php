<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Chunking\ChunkingStrategy;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
class FileSearchResourcesVectorStore
{
    public function __construct(

        #[Assert\Count(max: 10000)]
        #[Assert\All(
            [
                new Assert\Type('string'),
                new Assert\NotBlank()
            ]
        )]
        public ?array $fileIds = null,

        public ?ChunkingStrategy $chunkingStrategy = null,

        #[Metadata]
        #[Assert\Count(max: 16)]
        public ?array $metadata = null
    ) {
    }
}