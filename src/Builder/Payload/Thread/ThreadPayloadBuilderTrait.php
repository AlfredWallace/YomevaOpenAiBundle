<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Builder\Payload\HasCodeInterpreterResourcesTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasFileSearchResourcesFullTrait;
use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;

trait ThreadPayloadBuilderTrait
{
    use HasMetadataTrait;
    use HasFileSearchResourcesFullTrait;
    use HasCodeInterpreterResourcesTrait;
}