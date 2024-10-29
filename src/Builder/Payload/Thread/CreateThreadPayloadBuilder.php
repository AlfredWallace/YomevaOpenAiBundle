<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;

class CreateThreadPayloadBuilder implements ThreadPayloadBuilderInterface
{
    use ThreadPayloadBuilderTrait;

    private CreateThreadPayload $createThreadPayload;

    /** Use the Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder helper */
    public function __construct(
        ?array $messages = null
    ) {
        $this->createThreadPayload = new CreateThreadPayload($messages);
    }

    public function getPayload(): CreateThreadPayload
    {
        return $this->createThreadPayload;
    }
}