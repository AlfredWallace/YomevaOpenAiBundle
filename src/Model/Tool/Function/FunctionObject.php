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

        /**
         * OpenAI doc :
         * The parameters the functions accepts, described as a JSON Schema object.
         *
         * See the guide for examples:
         * https://platform.openai.com/docs/guides/function-calling
         *
         * And the JSON Schema reference for documentation about the format :
         * https://json-schema.org/understanding-json-schema
         */
        public ?array $parameters = null,

        public ?bool $strict = null,
    )
    {
    }
}