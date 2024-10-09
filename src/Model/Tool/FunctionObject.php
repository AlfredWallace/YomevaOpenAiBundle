<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FunctionObject
{
    public function __construct(

        // TODO assert a-z, A-Z, 0-9, underscores, dashes, max 64
        public string $name,

        public ?string $description = null,

        #[Assert\Json]
        public ?string $parameters = null,

        public bool $strict = false,
    )
    {
    }
}