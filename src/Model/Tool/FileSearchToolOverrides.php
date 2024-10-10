<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FileSearchToolOverrides
{
    public function __construct(

        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(50)]
        public int $maxNumResults = 20,

        #[Assert\Valid]
        public ?FileSearchRankingOptions $rankingOptions = null
    )
    {
    }
}