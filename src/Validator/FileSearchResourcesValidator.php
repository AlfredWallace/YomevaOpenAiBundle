<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchResources as FileSearchResourcesModel;

class FileSearchResourcesValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof FileSearchResources) {
            throw new UnexpectedTypeException($constraint, FileSearchResources::class);
        }

        if (!$value instanceof FileSearchResourcesModel) {
            throw new UnexpectedValueException($value, FileSearchResourcesModel::class);
        }

        if (!empty($value->vectorStoreIds) && !empty($value->vectorStores)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}