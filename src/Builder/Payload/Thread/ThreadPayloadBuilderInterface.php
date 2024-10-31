<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\HasCodeInterpreterResourcesInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasFileSearchResourcesFullInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Thread\ThreadPayload;

interface ThreadPayloadBuilderInterface
    extends PayloadBuilderInterface,
            HasMetadataInterface,
            HasFileSearchResourcesFullInterface,
            HasCodeInterpreterResourcesInterface
{
    public function getPayload(): ThreadPayload;
}