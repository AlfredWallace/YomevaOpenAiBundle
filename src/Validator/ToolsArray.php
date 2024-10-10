<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearchTool;
use Yomeva\OpenAiBundle\Model\Tool\FunctionTool;

#[\Attribute]
class ToolsArray extends Constraint
{
    private const array TOOLS = [
        CodeInterpreterTool::class,
        FileSearchTool::class,
        FunctionTool::class
    ];

    public string $message;

    public function __construct(?string $message = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? "One or more of the given values is invalid. Valid values are: " . implode(
            ',',
            self::TOOLS
        );;
    }
}