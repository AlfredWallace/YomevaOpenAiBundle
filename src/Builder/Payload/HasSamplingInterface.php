<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasSamplingInterface
{
    public function setTemperature(float $temperature): self;

    public function setTopP(float $topP): self;
}