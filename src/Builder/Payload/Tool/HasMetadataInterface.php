<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Tool;

interface HasMetadataInterface
{
    public function setMetadata(array $metadata): self;

    public function addMetadata(string $key, string $value): self;
}