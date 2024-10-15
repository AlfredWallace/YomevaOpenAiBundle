<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

use Symfony\Component\Validator\Constraints as Assert;

class JsonSchemaResponseFormatObject
{
    public function __construct(

        #[Assert\Length(max: 64)]
        #[Assert\Regex(pattern: '/^[a-zA-Z0-9_\-]+$/')]
        public string $name,

        /**
         * The schema for the response format, described as a JSON Schema object.
         * See: https://json-schema.org/understanding-json-schema
         */
        public array $schema,

        public ?string $description = null,

        public ?bool $strict = null
    )
    {
    }
}