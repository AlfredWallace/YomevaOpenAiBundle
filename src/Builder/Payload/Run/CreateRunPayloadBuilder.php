<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Model\Run\CreateRunPayload;

class CreateRunPayloadBuilder implements CreateRunBasePayloadBuilderInterface
{
    use CreateRunBasePayloadBuilderTrait;

    private CreateRunPayload $createRunPayload;

    public function __construct(string $assistantId)
    {
        $this->createRunPayload = new CreateRunPayload($assistantId);
    }

    public function getPayload(): CreateRunPayload
    {
        return $this->createRunPayload;
    }
}