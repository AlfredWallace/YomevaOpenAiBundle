<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasToolResourcesFullInterface;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Thread\ThreadPayload;

interface ThreadPayloadBuilderInterface extends PayloadBuilderInterface, HasMetadataInterface, HasToolResourcesFullInterface
{
    public function getPayload(): ThreadPayload;
}