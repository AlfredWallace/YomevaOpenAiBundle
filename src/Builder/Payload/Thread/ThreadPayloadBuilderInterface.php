<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Thread\ThreadPayload;

interface ThreadPayloadBuilderInterface extends PayloadBuilderInterface
{
    public function getPayload(): ThreadPayload;
}