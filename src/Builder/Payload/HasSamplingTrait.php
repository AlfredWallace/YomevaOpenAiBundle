<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;

trait HasSamplingTrait
{
    abstract public function getPayload(): PayloadInterface;

    public function setTemperature(float $temperature): self
    {
        $this->getPayload()->temperature = $temperature;
        return $this;
    }

    public function setTopP(float $topP): self
    {
        $this->getPayload()->topP = $topP;
        return $this;
    }
}