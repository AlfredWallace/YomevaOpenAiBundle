<?php

namespace Yomeva\OpenAiBundle\Model\Message;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Attachments\Attachment;
use Yomeva\OpenAiBundle\Model\Content\ContentPart;
use Yomeva\OpenAiBundle\Validator\MessageContentType;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateMessagePayload extends MessagePayload
{
    /**
     * @param Role $role
     * @param string|ContentPart[] $content
     * @param Attachment[]|null $attachments
     * @param array<string, string>|null $metadata
     */
    public function __construct(
        public Role $role,

        #[Assert\NotBlank]
        #[MessageContentType]
        public string|array $content,

        #[TypedArray([
            Attachment::class
        ])]
        public ?array $attachments = null,

        public ?array $metadata = null
    ) {
        parent::__construct($metadata);
    }
}