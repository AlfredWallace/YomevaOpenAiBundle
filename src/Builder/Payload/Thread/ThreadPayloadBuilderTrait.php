<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasToolResourcesTrait;

trait ThreadPayloadBuilderTrait
{
    use HasMetadataTrait;
    use HasToolResourcesTrait;
}