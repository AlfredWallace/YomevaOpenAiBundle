<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Yomeva\OpenAiBundle\Model\Assistant\AssistantToolResponseFormatInterface;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonObjectResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\JsonSchemaResponseFormat;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionTool;

class AssistantToolsResponseFormatValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AssistantToolsResponseFormat) {
            throw new UnexpectedTypeException($constraint, AssistantToolsResponseFormat::class);
        }

        if (!$value instanceof AssistantToolResponseFormatInterface) {
            throw new UnexpectedValueException($value, AssistantToolResponseFormatInterface::class);
        }

        if ($value->getResponseFormat() === null || $value->getResponseFormat() === ResponseFormat::AUTO || empty($value->getTools())) {
            return;
        }

        if ($this->containsNotFunctionTools($value) && $this->isJsonResponse($value)) {
            $this->context->buildViolation(
                "You cannot have a json_schema or json_object response format if you add other tools than function tools.
            Either keep your tools and change the response format to 'auto' or 'text', or remove tools that aren't function tools."
            )
                ->addViolation();
        }
    }

    private function isJsonResponse(AssistantToolResponseFormatInterface $payload): bool
    {
        return $payload->getResponseFormat() instanceof JsonObjectResponseFormat ||
            $payload->getResponseFormat() instanceof JsonSchemaResponseFormat;
    }

    private function containsNotFunctionTools(AssistantToolResponseFormatInterface $payload): bool
    {
        foreach ($payload->getTools() as $tool) {
            if (!$tool instanceof FunctionTool) {
                return true;
            }
        }

        return false;
    }
}