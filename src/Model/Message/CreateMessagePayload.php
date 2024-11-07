<?php

namespace Yomeva\OpenAiBundle\Model\Message;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Attachments\Attachment;
use Yomeva\OpenAiBundle\Validator\MessageContentType;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateMessagePayload extends MessagePayload
{
    public function __construct(
        public Role $role,

        #[Assert\NotBlank]
        #[MessageContentType]
        public string|array $content,

        #[TypedArray([
            Attachment::class
        ])]
        public ?array $attachments = null,

        ...$arguments,
    ) {
        parent::__construct(...$arguments);
    }
}