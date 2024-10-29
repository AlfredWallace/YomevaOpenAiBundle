<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Validation;
use Yomeva\OpenAiBundle\Model\Content\ImageFileContentPart;
use Yomeva\OpenAiBundle\Model\Content\ImageUrlContentPart;
use Yomeva\OpenAiBundle\Model\Content\TextContentPart;

class MessageContentTypeValidator extends ConstraintValidator
{
    /**
     * @param string|array $value
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof MessageContentType) {
            throw new UnexpectedTypeException($constraint, MessageContentType::class);
        }

        if (!is_string($value) && !is_array($value)) {
            throw new UnexpectedValueException($value, 'string|array');
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (empty($value)) {
            return;
        }

        // No additional validation when it's a string
        if (is_string($value)) {
            return;
        }

        $validator = Validation::createValidator();
        $violations = $validator->validate(
            $value,
            new TypedArray([
                TextContentPart::class,
                ImageFileContentPart::class,
                ImageUrlContentPart::class,
            ])
        );

        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $this->context->buildViolation($violation->getMessage())
                    ->addViolation();
            }
        }
    }
}