<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Chunking\ChunkingStrategy;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
class FileSearchResourcesVectorStore
{
    /**
     * @param string[]|null $fileIds
     * @param ChunkingStrategy|null $chunkingStrategy
     * @param array<string, string>|null $metadata
     */
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