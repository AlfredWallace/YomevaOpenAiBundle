<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class MetadataValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Metadata) {
            throw new UnexpectedTypeException($constraint, Metadata::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $key => $element) {
            if (
                !is_string($key) ||
                strlen($key) > Metadata::MAX_KEY_LENGTH ||
                !is_string($element) ||
                strlen($element) > Metadata::MAX_VALUE_LENGTH
            ) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}