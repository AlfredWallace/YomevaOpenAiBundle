<?php

namespace Yomeva\OpenAiBundle\Builder;

use Yomeva\OpenAiBundle\Model\PayloadInterface;

interface PayloadBuilderInterface
{
    public function getPayload(): PayloadInterface;
}