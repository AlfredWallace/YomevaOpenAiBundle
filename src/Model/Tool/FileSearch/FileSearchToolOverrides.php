<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
class FileSearchToolOverrides
{
    public function __construct(

        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(50)]
        public ?int $maxNumResults = null,

        public ?FileSearchRankingOptions $rankingOptions = null
    ) {
    }
}