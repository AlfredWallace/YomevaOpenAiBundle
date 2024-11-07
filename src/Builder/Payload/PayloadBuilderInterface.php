<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\PayloadInterface;

interface PayloadBuilderInterface
{
    public function getPayload(): PayloadInterface;
}