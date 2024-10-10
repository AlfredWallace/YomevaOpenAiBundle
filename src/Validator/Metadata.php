<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Metadata extends Constraint
{
    public const int MAX_KEY_LENGTH = 64;
    public const int MAX_VALUE_LENGTH = 512;

    public string $message;

    public function __construct(?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = "The array must have string keys of max. " . self::MAX_KEY_LENGTH . " chars and string values of max. " . self::MAX_VALUE_LENGTH . " chars.";
    }
}