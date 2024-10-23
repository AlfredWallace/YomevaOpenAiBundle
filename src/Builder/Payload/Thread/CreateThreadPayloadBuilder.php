<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;

class CreateThreadPayloadBuilder implements ThreadPayloadBuilderInterface
{
    use ThreadPayloadBuilderTrait;

    private CreateThreadPayload $createThreadPayload;

    public function __construct(
        // TODO when Message models will be done
        ?array $messages = null
    ) {
        $this->createThreadPayload = new CreateThreadPayload($messages);
    }

    public function getPayload(): CreateThreadPayload
    {
        return $this->createThreadPayload;
    }
}