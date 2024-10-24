<?php

namespace Yomeva\OpenAiBundle\Model\Message;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
abstract class MessagePayload implements PayloadInterface
{
    public function __construct(
        #[Metadata]
        public ?array $metadata = null
    ) {
    }
}