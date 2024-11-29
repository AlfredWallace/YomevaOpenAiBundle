<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasResponseFormatInterface
{
    public function setResponseFormatToAuto(): self;

    public function setResponseFormatToText(): self;

    public function setResponseFormatToJsonObject(): self;

    /**
     * @param string $name
     * @param array<string, mixed> $schema
     * @param string|null $description
     * @param bool|null $strict
     * @return self
     */
    public function setResponseFormatToJsonSchema(
        string $name,
        array $schema,
        ?string $description = null,
        ?bool $strict = null
    ): self;
}