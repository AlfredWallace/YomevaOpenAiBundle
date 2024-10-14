<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class FunctionObjectParametersCollection extends Constraint
{
    public function __construct(?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}