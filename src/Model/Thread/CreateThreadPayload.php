<?php

namespace Yomeva\OpenAiBundle\Model\Thread;

use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesFull;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateThreadPayload extends ThreadPayload
{
    /**
     * @param CreateMessagePayload[]|null $messages
     * @param ToolResourcesFull|null $toolResources
     * @param array<string, string>|null $metadata
     */
    public function __construct(

        #[TypedArray([CreateMessagePayload::class])]
        public ?array $messages = null,

        public ?ToolResourcesFull $toolResources = null,
        public ?array $metadata = null,
    ) {
        parent::__construct($toolResources, $metadata);
    }
}