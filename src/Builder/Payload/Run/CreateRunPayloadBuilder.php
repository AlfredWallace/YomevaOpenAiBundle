<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Run;

use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
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

    public function setAdditionalInstructions(string $additionalInstructions): self
    {
        $this->createRunPayload->additionalInstructions = $additionalInstructions;
        return $this;
    }

    /**
     * To easily add a message, use the Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder
     * Example :
     * $openAiClient->addAdditionalMessage(
     *     (new CreateMessagePayloadBuilder(Role::User, "message part 1"))
     *          ->addText("message part 2")
     *          ...
     *          ->getPayload()
     * );
     */
    public function addAdditionalMessage(CreateMessagePayload $message): self
    {
        $this->createRunPayload->additionalMessages[] = $message;
        return $this;
    }

    /**
     * @param CreateMessagePayload[] $additionalMessages
     */
    public function setAdditionalMessages(array $additionalMessages): self
    {
        $this->createRunPayload->additionalMessages = $additionalMessages;
        return $this;
    }
}