<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;

trait HasMetadataTrait
{
    abstract public function getPayload(): PayloadInterface;

    public function setMetadata(array $metadata): self
    {
        $this->getPayload()->metadata = $metadata;
        return $this;
    }

    public function addMetadata(string $key, string $value): self
    {
        if ($this->getPayload()->metadata === null) {
            $this->getPayload()->metadata = [];
        }

        $this->getPayload()->metadata[$key] = $value;
        return $this;
    }
}