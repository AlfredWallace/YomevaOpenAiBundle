<?php

namespace Yomeva\OpenAiBundle\Model\Tool\Function;

use Yomeva\OpenAiBundle\Model\JsonSchemaType;

class FunctionObjectParameter
{
    public function __construct(
        public JsonSchemaType $type,
        public ?string $description = null,
        public ?array $enum = null
    ) {
    }
}