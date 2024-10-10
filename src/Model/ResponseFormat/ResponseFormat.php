<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

abstract class ResponseFormat
{
    public function __construct(public readonly string $type)
    {
    }
}