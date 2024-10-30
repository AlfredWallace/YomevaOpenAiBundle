<?php

namespace Yomeva\OpenAiBundle\Model\TruncationStrategy;

use Symfony\Component\Validator\Constraints as Assert;

class TruncationStrategy
{
    public function __construct(
        public TruncationStrategyType $type = TruncationStrategyType::Auto,

        #[Assert\Expression(
            "this.type !== TruncationStrategyType::LastMessages or this.lastMessages !== null",
            message: "The number of messages (lastMessages) is mandatory if the type is LastMessages."
        )]
        public ?int $lastMessages = null
    ) {
    }
}