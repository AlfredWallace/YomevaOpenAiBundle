<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Message;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Message\ModifyMessagePayload;

class ModifyMessagePayloadBuilder implements PayloadBuilderInterface, HasMetadataInterface
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