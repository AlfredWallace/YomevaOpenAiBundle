<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
abstract class RunPayload implements PayloadInterface
{
    public function __construct(

        #[Metadata]
        #[Assert\Count(max: 16)]
        public ?array $metadata = null,
    ) {
    }
}