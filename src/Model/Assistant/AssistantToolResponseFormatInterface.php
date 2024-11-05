<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

use Yomeva\OpenAiBundle\Model\PayloadInterface;
use Yomeva\OpenAiBundle\Model\ResponseFormat\ResponseFormat;

interface AssistantToolResponseFormatInterface extends PayloadInterface
{
    public function getTools(): ?array;
    public function getResponseFormat(): string|ResponseFormat|null;
}