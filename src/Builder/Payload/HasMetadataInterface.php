<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasMetadataInterface
{
    /**
     * @param array<string, string> $metadata
     */
    public function setMetadata(array $metadata): self;

    public function addMetadata(string $key, string $value): self;
}