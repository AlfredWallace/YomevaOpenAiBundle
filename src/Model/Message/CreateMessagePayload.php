<?php

namespace Yomeva\OpenAiBundle\Model\Message;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Attachments\Attachment;
use Yomeva\OpenAiBundle\Model\Content\ContentPart;
use Yomeva\OpenAiBundle\Model\Content\ImageFileContentPart;
use Yomeva\OpenAiBundle\Model\Content\ImageUrlContentPart;
use Yomeva\OpenAiBundle\Model\Content\TextContentPart;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;
use Yomeva\OpenAiBundle\Validator\MessageContentType;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateMessagePayload extends MessagePayload
{
    /**
     * @param Role $role
     * @param mixed[] $content
     * @param Attachment[]|null $attachments
     * @param array<string, string>|null $metadata
     */
    public function __construct(
        public Role $role,

        #[Assert\All([new Assert\NotBlank()])]
        #[TypedArray(
            [
                TextContentPart::class,
                ImageFileContentPart::class,
                ImageUrlContentPart::class
            ]
        )]
        public array $content,

        #[TypedArray([
            Attachment::class
        ])]
        public ?array $attachments = null,

        public ?array $metadata = null
    ) {
        parent::__construct($metadata);
    }
}