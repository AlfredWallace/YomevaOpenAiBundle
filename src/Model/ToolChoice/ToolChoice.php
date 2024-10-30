<?php

namespace Yomeva\OpenAiBundle\Model\ToolChoice;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Model\Tool\ToolType;

#[Assert\Cascade]
class ToolChoice
{
    public function __construct(
        public ToolType $type,
        public ?ToolChoiceFunction $function = null,
    ) {
    }
}