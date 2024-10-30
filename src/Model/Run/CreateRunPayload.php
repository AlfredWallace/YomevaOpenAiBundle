<?php

namespace Yomeva\OpenAiBundle\Model\Run;

class CreateRunPayload extends BaseCreateRunPayload
{
    public function __construct(
        string $assistantId,
        // todo additionalInstructions
        // todo additionalMessages
        ...$arguments,
    )
    {
        parent::__construct($assistantId, ...$arguments);
    }
}