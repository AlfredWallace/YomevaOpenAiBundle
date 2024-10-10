<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

class TextResponseFormat extends ResponseFormat
{
    public function __construct()
    {
        parent::__construct('text');
    }
}