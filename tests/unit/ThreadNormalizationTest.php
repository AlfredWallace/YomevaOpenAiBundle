<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Yomeva\OpenAiBundle\Builder\Payload\Thread\CreateThreadPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\ModifyThreadPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\ThreadPayloadBuilder;

class ThreadNormalizationTest extends NormalizationTestCase
{
    /**
     * @dataProvider threadDataProvider
     */
    public function testCreateThread(callable $payloadFunction, array $expected): void
    {
        $this->assertEqualsAssociativeArraysRecursive(
            expected: $expected,
            actual: self::$serializer->normalize(
                $payloadFunction(new CreateThreadPayloadBuilder())->getPayload()
            ),
        );
    }

    /**
     * @dataProvider threadDataProvider
     */
    public function testModifyThread(callable $payloadFunction, array $expected): void
    {
        $this->assertEqualsAssociativeArraysRecursive(
            expected: $expected,
            actual: self::$serializer->normalize(
                $payloadFunction(new ModifyThreadPayloadBuilder())->getPayload()
            )
        );
    }

    public function threadDataProvider(): array
    {
        return [
            'basic_test' => [
                'payloadFunction' => function (ThreadPayloadBuilder $builder) {
                    return $builder;
                },
                'expected' => []
            ]
        ];
    }
}