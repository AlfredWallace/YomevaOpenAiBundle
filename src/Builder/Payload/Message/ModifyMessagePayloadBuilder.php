<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Message;

use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataTrait;
use Yomeva\OpenAiBundle\Model\Message\ModifyMessagePayload;

class ModifyMessagePayloadBuilder implements MessagePayloadBuilderInterface
{
    use HasMetadataTrait;

    private ModifyMessagePayload $modifyMessagePayload;

    public function __construct()
    {
        $this->modifyMessagePayload = new ModifyMessagePayload();
    }

    public function getPayload(): ModifyMessagePayload
    {
        return $this->modifyMessagePayload;
    }
}