<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasToolResourcesInterface;
use Yomeva\OpenAiBundle\Model\Thread\ThreadPayload;

interface ThreadPayloadBuilderInterface extends PayloadBuilderInterface, HasMetadataInterface, HasToolResourcesInterface
{
    public function getPayload(): ThreadPayload;
}