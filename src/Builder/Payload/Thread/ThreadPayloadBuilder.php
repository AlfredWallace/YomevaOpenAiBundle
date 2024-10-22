<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasToolResourcesTrait;
use Yomeva\OpenAiBundle\Model\Thread\ThreadPayload;

abstract class ThreadPayloadBuilder implements PayloadBuilderInterface
{
    use HasMetadataTrait;
    use HasToolResourcesTrait;

    protected ThreadPayload $threadPayload;

    public function getPayload(): ThreadPayload
    {
        return $this->threadPayload;
    }
}