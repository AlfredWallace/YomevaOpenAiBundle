<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

class JsonSchema
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $schema = null,
        public bool $strict = false
    )
    {
    }
}