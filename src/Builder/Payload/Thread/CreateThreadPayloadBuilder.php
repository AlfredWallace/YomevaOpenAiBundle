<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;

class CreateThreadPayloadBuilder extends ThreadPayloadBuilder
{
    public function __construct(
        // TODO when Message models will be done
        ?array $messages = null
    )
    {
        $this->threadPayload = new CreateThreadPayload($messages);
    }
}