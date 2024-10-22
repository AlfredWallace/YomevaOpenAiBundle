<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Model\Thread\ModifyThreadPayload;

class ModifyThreadPayloadBuilder extends ThreadPayloadBuilder
{
    public function __construct()
    {
        $this->threadPayload = new ModifyThreadPayload();
    }
}