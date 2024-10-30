<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Thread;

use Yomeva\OpenAiBundle\Model\Thread\CreateThreadPayload;

class CreateThreadPayloadBuilder implements ThreadPayloadBuilderInterface
{
    use ThreadPayloadBuilderTrait;

    private CreateThreadPayload $createThreadPayload;

    /**
     * If you want to create a Thread with Messages (instead of creating Messages for the Thread afterwards),
     * use the Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder helper.
     * Example :
     *
     * $openAiClient->createThread(
     *     (new CreateThreadPayloadBuilder(
     *         [
     *             (new CreateMessagePayloadBuilder(Role::User, "my message"))
     *                 ...
     *                 ->getPayload(),
     *
     *             (new CreateMessagePayloadBuilder(Role::Assistant, "Your message is understood"))
     *                 ...
     *                 ->getPayload(),
     *         ]
     *     ))->getPayload();
     * );
     */
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