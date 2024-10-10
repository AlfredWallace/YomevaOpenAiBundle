<?php

namespace Yomeva\OpenAiBundle\Model\Chunking;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Expression(
    "this.chunkOverlapTokens <= this.maxChunkSizeTokens / 2",
    message: "The number of chunk overlap tokens must be max. half of the max chunk size."
)]
class StaticChunkingStrategyStatic
{
    public function __construct(

        #[Assert\GreaterThanOrEqual(100)]
        #[Assert\LessThanOrEqual(4096)]
        public int $maxChunkSizeTokens = 800,

        public int $chunkOverlapTokens = 400,
    )
    {
    }
}