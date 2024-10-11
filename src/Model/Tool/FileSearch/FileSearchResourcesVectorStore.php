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
        public array $fileIds = [],

        public ?ChunkingStrategy $chunkingStrategy = null,

        #[Assert\Count(max: 16)]
        #[Metadata]
        public array $metadata = []
    ) {
    }
}