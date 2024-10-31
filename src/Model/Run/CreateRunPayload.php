<?php

namespace Yomeva\OpenAiBundle\Model\Run;

use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateRunPayload extends CreateRunPayloadBase
{
    public function __construct(
        public string $assistantId,
        public ?string $additionalInstructions = null,

        #[TypedArray([CreateMessagePayload::class])]
        public ?array $additionalMessages = null,
        ...$arguments,
    )
    {
        parent::__construct($assistantId, ...$arguments);
    }
}