<?php

namespace Yomeva\OpenAiBundle\Model\Message;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Attachments\Attachment;
use Yomeva\OpenAiBundle\Model\Content\ImageFileContentPart;
use Yomeva\OpenAiBundle\Model\Content\ImageUrlContentPart;
use Yomeva\OpenAiBundle\Model\Content\TextContentPart;
use Yomeva\OpenAiBundle\Validator\TypedArray;

class CreateMessagePayload extends MessagePayload
{
    public function __construct(
        public Role $role,

        #[Assert\AtLeastOneOf([
            new Assert\All([
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ]),
            new Assert\All([
                new TypedArray([
                    TextContentPart::class,
                    ImageFileContentPart::class,
                    ImageUrlContentPart::class,
                ]),
                new Assert\Count(min: 1)
            ])
        ])]
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