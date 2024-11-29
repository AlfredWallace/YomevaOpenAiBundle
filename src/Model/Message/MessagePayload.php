<?php

namespace Yomeva\OpenAiBundle\Model\Message;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
abstract class MessagePayload implements PayloadInterface
{
    /**
     * @param array<string, string>|null $metadata
     */
    public function __construct(

        #[Metadata]
        #[Assert\Count(max: 16)]
        public ?array $metadata = null
    ) {
    }
}