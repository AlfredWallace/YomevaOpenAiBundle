<?php

namespace Yomeva\OpenAiBundle\Model\Thread;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesFull;
use Yomeva\OpenAiBundle\Validator\Metadata;

#[Assert\Cascade]
abstract class ThreadPayload implements PayloadInterface
{
    /**
     * @param ToolResourcesFull|null $toolResources
     * @param array<string, string>|null $metadata
     */
    public function __construct(
        public ?ToolResourcesFull $toolResources = null,

        #[Metadata]
        #[Assert\Count(max: 16)]
        public ?array $metadata = null,
    ) {
    }
}