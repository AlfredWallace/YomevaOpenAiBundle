<?php

namespace Yomeva\OpenAiBundle\Model;

enum JsonSchemaType: string
{
    case String = 'string';
    case Number = 'number';
    case Integer = 'integer';
    case Object = 'object';
    case Array = 'array';
    case Boolean = 'boolean';
    case Null = 'null';
}
