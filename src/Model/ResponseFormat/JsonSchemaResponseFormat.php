<?php

namespace Yomeva\OpenAiBundle\Model\ResponseFormat;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
class JsonSchemaResponseFormat extends ResponseFormat
{
    public function __construct(public JsonSchemaResponseFormatObject $jsonSchema)
    {
        parent::__construct('json_schema');
    }
}