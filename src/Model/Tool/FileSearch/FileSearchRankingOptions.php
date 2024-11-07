<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Symfony\Component\Validator\Constraints as Assert;

class FileSearchRankingOptions
{
    public function __construct(

        #[Assert\GreaterThanOrEqual(0.0)]
        #[Assert\LessThanOrEqual(1.0)]
        public float $scoreThreshold,

        public ?Ranker $ranker = null
    ) {
    }
}