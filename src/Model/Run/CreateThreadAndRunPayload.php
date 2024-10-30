<?php

namespace Yomeva\OpenAiBundle\Model\Run;

class CreateThreadAndRunPayload extends BaseCreateRunPayload
{
    public function __construct(
        string $assistantId,
        // todo Thread
        // todo toolResources
        ...$arguments
    ) {
        parent::__construct($assistantId, ...$arguments);
    }
}