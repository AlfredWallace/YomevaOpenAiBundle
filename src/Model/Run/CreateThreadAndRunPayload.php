<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;
use Yomeva\OpenAiBundle\Model\ToolResources\ToolResourcesSimple;

class CreateThreadAndRunPayload extends BaseCreateRunPayload
{
    public function __construct(
        public string $assistantId,
        public ?CreateThreadPayload $thread = null,
        public ?ToolResourcesSimple $toolResources = null,
        ...$arguments
    ) {
        parent::__construct($assistantId, ...$arguments);
    }
}