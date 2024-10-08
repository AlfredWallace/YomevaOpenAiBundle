<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FunctionObject
{
    public function __construct(

        #[Assert\Length(max: 64)]
        #[Assert\Regex(pattern: '/^[a-zA-Z0-9_\-]+$/')]
        public string $name,

        public ?string $description = null,

        #[Assert\Json]
        public ?string $parameters = null,

        public bool $strict = false,
    )
    {
    }
}