<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
#[Assert\Expression(
    "!(this.codeInterpreter === null and this.fileSearch === null)",
    message: "You must provide at least one of the two ToolResources."
)]
abstract class ToolResourcesBase
{
    public function __construct(
        public ?CodeInterpreterResources $codeInterpreter = null,
        public ?FileSearchResourcesBase $fileSearch = null,
    ) {
    }
}