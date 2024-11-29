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

        // If response format is not set or is auto, no need to check tools
        if ($value->getResponseFormat() === null || $value->getResponseFormat() === ResponseFormat::AUTO) {
            return;
        }

        // If there are no tools, no need to check response format
        $tools = $value->getTools();
        if (empty($tools)) {
            return;
        }

        if ($this->containsOtherToolsThanFunctionTool($tools) && $this->isJsonResponse($value)) {
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

    /**
     * @param mixed[] $tools
     * @return bool
     */
    private function containsOtherToolsThanFunctionTool(array $tools): bool
    {
        foreach ($tools as $tool) {
            if (!$tool instanceof FunctionTool) {
                return true;
            }
        }

        return false;
    }
}