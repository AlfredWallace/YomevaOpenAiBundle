<?php

namespace Yomeva\OpenAiBundle\Model\Tool\Function;

use Yomeva\OpenAiBundle\Model\JsonSchemaType;

class FunctionObjectParameter
{
    public function __construct(
        public JsonSchemaType $type,
        public ?string $description = null,

        // Maybe add some constraint to check if every element
        // of the array is of type $type
        public ?array $enum = null
    ) {
    }
}