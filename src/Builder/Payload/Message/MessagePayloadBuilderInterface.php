<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Message;

use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataInterface;
use Yomeva\OpenAiBundle\Model\Message\MessagePayload;

interface MessagePayloadBuilderInterface extends PayloadBuilderInterface, HasMetadataInterface
{
    public function getPayload(): MessagePayload;
}