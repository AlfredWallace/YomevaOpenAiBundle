<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Model\Run\CreateThreadAndRunPayload;
use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;

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

    /**
     * To easily set the Thread, use Yomeva\OpenAiBundle\Builder\Payload\Thread\CreateThreadPayloadBuilder
     * Example:
     * $openAiClient->setThread(
     *     (new CreateThreadPayloadBuilder())
     *     ...
     *     ->getPayload()
     * );
     */
    public function setThread(CreateThreadPayload $thread): self
    {
        $this->createThreadAndRunPayload->thread = $thread;
        return $this;
    }
}