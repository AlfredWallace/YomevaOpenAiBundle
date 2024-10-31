<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Run\ModifyRunPayload;

class ModifyRunPayloadBuilder implements PayloadBuilderInterface, HasMetadataInterface
{
    use HasMetadataTrait;

    private ModifyRunPayload $modifyRunPayload;

    public function __construct()
    {
        $this->modifyRunPayload = new ModifyRunPayload();
    }

    public function getPayload(): ModifyRunPayload
    {
        return $this->modifyRunPayload;
    }
}