<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FileSearchRankingOptions
{
    public function __construct(

        #[Assert\GreaterThanOrEqual(0)]
        #[Assert\LessThanOrEqual(1)]
        public float $scoreThreshold,


        // enum 'auto', 'default_2024_08_21'
        public string $ranker = 'auto'
    )
    {
    }
}