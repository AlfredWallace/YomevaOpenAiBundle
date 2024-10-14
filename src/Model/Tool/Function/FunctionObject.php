<?php

namespace Yomeva\OpenAiBundle\Model\Tool\Function;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
class FunctionObject
{
    public function __construct(

        #[Assert\Length(max: 64)]
        #[Assert\Regex(pattern: '/^[a-zA-Z0-9_\-]+$/')]
        public string $name,

        public ?string $description = null,

        public ?FunctionObjectParametersCollection $parameters = null,

        public ?bool $strict = null,
    )
    {
    }
}