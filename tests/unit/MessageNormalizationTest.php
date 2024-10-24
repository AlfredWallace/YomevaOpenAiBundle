<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Message\MessagePayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Message\Role;

final class MessageNormalizationTest extends NormalizationTestCase
{
    /**
     * @dataProvider messageDataProvider
     *
     * @param callable(): CreateMessagePayloadBuilder $payloadFunction
     */
    public function testCreateMessage(callable $payloadFunction, array $expected): void
    {
        $this->assertEqualsAssociativeArraysRecursive(
            $expected,
            self::$serializer->normalize(
                $payloadFunction(new CreateMessagePayloadBuilder(Role::User))->getPayload(),
            )
        );
    }

    public function messageDataProvider(): array
    {
        return [
            'basic_test' => [
                'payloadFunction' =>
                    function (MessagePayloadBuilderInterface $builder): MessagePayloadBuilderInterface {
                        return $builder;
                    },
                'expected' => [
                    'role' => Role::User->value,
                    'content' => []
                ]
            ]
        ];
    }
}