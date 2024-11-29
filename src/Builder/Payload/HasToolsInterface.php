<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

interface HasToolsInterface
{
    public function addCodeInterpreterTool(): self;

    /**
     * @param string $name
     *
     * @param string|null $description
     *
     *  The parameters the functions accepts, described as a JSON Schema object.
     *  See the guide for examples: https://platform.openai.com/docs/guides/function-calling
     *  And the JSON Schema reference for documentation about the format: https://json-schema.org/understanding-json-schema
     * @param array<string, mixed>|null $parameters
     *
     * @param bool|null $strict
     *
     * @return self
     */
    public function addFunctionTool(
        string $name,
        ?string $description = null,
        ?array $parameters = null,
        ?bool $strict = null
    ): self;

    public function addFileSearchTool(
        ?int $maxNumResults = null,
        ?float $scoreThreshold = null,
        ?Ranker $ranker = null
    ): self;
}