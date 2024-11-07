<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Model\Thread\ModifyThreadPayload;

class ModifyThreadPayloadBuilder implements ThreadPayloadBuilderInterface
{
    use ThreadPayloadBuilderTrait;

    private ModifyThreadPayload $modifyThreadPayload;

    public function __construct()
    {
        $this->modifyThreadPayload = new ModifyThreadPayload();
    }

    public function getPayload(): ModifyThreadPayload
    {
        return $this->modifyThreadPayload;
    }
}