<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TypedArrayValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof TypedArray) {
            throw new UnexpectedTypeException($constraint, TypedArray::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $element) {
            $elementIsValid = false;

            foreach ($constraint->validTypes as $validType) {
                if ($element instanceof $validType) {
                    $elementIsValid = true;
                    break;
                }
            }

            if (!$elementIsValid) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}