<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

use Symfony\Component\Validator\Constraints as Assert;

class JsonSchema
{
    public function __construct(

        #[Assert\Length(max: 64)]
        #[Assert\Regex(pattern: '/^[a-zA-Z0-9_\-]+$/')]
        public string $name,

        public ?string $description = null,

        #[Assert\Json]
        public ?string $schema = null,

        public ?bool $strict = null
    )
    {
    }
}