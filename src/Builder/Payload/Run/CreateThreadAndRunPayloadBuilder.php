<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Model\Run\CreateThreadAndRunPayload;

class CreateThreadAndRunPayloadBuilder implements CreateRunBasePayloadBuilderInterface
{
    use CreateRunBasePayloadBuilderTrait;

    private CreateThreadAndRunPayload $createThreadAndRunPayload;

    public function __construct(string $assistantId)
    {
        $this->createThreadAndRunPayload = new CreateThreadAndRunPayload($assistantId);
    }

    public function getPayload(): CreateThreadAndRunPayload
    {
        return $this->createThreadAndRunPayload;
    }
}