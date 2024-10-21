<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
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

        if (!$value instanceof CreateAssistantPayload) {
            throw new UnexpectedValueException($value, CreateAssistantPayload::class);
        }

        if ($value->responseFormat === null || $value->responseFormat === ResponseFormat::AUTO || empty($value->tools)) {
            return;
        }

        if ($this->containsNotFunctionTools($value) && $this->isJsonResponse($value)) {
            $this->context->buildViolation("You cannot have a json_schema or json_object response format if you add other tools than function tools.
            Either keep your tools and change the response format to 'auto' or 'text', or remove tools that aren't function tools.")
                ->addViolation();
        }
    }

    private function isJsonResponse(CreateAssistantPayload $payload): bool
    {
        return $payload->responseFormat instanceof JsonObjectResponseFormat ||
            $payload->responseFormat instanceof JsonSchemaResponseFormat;
    }

    private function containsNotFunctionTools(CreateAssistantPayload $payload): bool
    {
        foreach ($payload->tools as $tool) {
            if (!$tool instanceof FunctionTool) {
                return true;
            }
        }

        return false;
    }
}