<?php

namespace Yomeva\OpenAiBundle\Model\Thread;

class CreateThreadPayload extends ThreadPayload
{
    public function __construct(
        // TODO when the models for Message are done
        public ?array $messages = null,
        ...$arguments
    ) {
        parent::__construct(...$arguments);
    }
}