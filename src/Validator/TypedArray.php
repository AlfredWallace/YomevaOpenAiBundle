<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TypedArray extends Constraint
{
    public string $message;

    /**
     * @param array<string> $validTypes
     */
    #[HasNamedArguments]
    public function __construct(
        public array $validTypes,
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct([], $groups, $payload);

        $this->message = "One or more of the given values is invalid. Valid values are: " . implode(', ', $this->validTypes);
    }
}