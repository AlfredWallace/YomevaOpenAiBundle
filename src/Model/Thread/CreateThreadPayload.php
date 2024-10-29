<?php

namespace Yomeva\OpenAiBundle\Model\Thread;

use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateThreadPayload extends ThreadPayload
{
    public function __construct(

        #[TypedArray([CreateMessagePayload::class])]
        public ?array $messages = null,
        ...$arguments
    ) {
        parent::__construct(...$arguments);
    }
}