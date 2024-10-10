<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FunctionTool;

class ToolsArrayValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ToolsArray) {
            throw new UnexpectedTypeException($constraint, ToolsArray::class);
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
            if (
                !$element instanceof CodeInterpreterTool &&
                !$element instanceof FileSearchTool &&
                !$element instanceof FunctionTool
            ) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}