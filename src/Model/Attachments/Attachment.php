<?php

namespace Yomeva\OpenAiBundle\Model\Attachments;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchBasicTool;
use Yomeva\OpenAiBundle\Validator\TypedArray;

#[Assert\Cascade]
class Attachment
{
    /**
     * @param string|null $fileId
     * @param mixed[]|null $tools
     */
    public function __construct(
        public ?string $fileId = null,

        #[Assert\Count(max: 2)]
        #[TypedArray([
            CodeInterpreterTool::class,
            FileSearchBasicTool::class
        ])]
        public ?array $tools = null,
    ) {
    }
}