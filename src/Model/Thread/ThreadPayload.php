<?php

namespace Yomeva\OpenAiBundle\Model\Thread;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\Tool\ToolResources;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
abstract class ThreadPayload implements PayloadInterface
{
    public function __construct(
        public ?ToolResources $toolResources = null,

        #[Metadata]
        #[Assert\Count(max: 16)]
        public ?array $metadata = null,
    ) {
    }
}