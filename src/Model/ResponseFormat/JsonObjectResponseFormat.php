<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

class JsonObjectResponseFormat extends ResponseFormat
{
    public function __construct()
    {
        parent::__construct('json_object');
    }
}