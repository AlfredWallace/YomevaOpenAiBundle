<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

class JsonSchemaResponseFormat extends ResponseFormat
{
    public function __construct(public JsonSchema $jsonSchema)
    {
        parent::__construct('json_schema');
    }
}