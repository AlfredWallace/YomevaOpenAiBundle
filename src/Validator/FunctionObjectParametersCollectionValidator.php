<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObjectParametersCollection as FunctionObjectParametersCollectionModel;

class FunctionObjectParametersCollectionValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof FunctionObjectParametersCollection) {
            throw new UnexpectedTypeException($constraint, FunctionObjectParametersCollection::class);
        }

        if (!$value instanceof FunctionObjectParametersCollectionModel) {
            throw new UnexpectedValueException($value, FunctionObjectParametersCollectionModel::class);
        }

        if ($value->properties === null || $value->required === null) {
            return;
        }

        if (count($value->required) > count($value->properties)) {
            $this->context->buildViolation("You cannot have more 'required' thant 'properties'.")
                ->addViolation();
            return;
        }

        $parameterKeys = array_keys($value->properties);

        foreach ($value->required as $required) {
            if (!in_array($required, $parameterKeys, true)) {
                $this->context->buildViolation("All values from 'required' have to be a key in 'properties'.")
                    ->addViolation();
                return;
            }
        }
    }
}