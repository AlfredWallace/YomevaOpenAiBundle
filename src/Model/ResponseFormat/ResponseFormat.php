<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

abstract class ResponseFormat
{
    public const string AUTO = 'auto';

    public function __construct(public readonly string $type)
    {
    }
}