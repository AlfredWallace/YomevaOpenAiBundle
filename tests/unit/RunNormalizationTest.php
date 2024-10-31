<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Yomeva\OpenAiBundle\Builder\Payload\Run\CreateRunPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Run\ModifyRunPayloadBuilder;
use Yomeva\OpenAiBundle\Model\Run\CreateRunPayload;

final class RunNormalizationTest extends NormalizationTestCase
{
    public function testModifyRun(): void
    {
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode([
                'metadata' => [
                    'foo' => 'bar',
                    'bar' => 'baz',
                ]
            ]),
            actualJson: self::$serializer->serialize(
                (new ModifyRunPayloadBuilder())
                    ->setMetadata([
                        "foo" => "bar",
                    ])
                    ->addMetadata("bar", "baz")
                    ->getPayload(),
                'json'
            )
        );
    }

    /**
     * @dataProvider createRunDataProvider
     */
    public function testCreateRun(CreateRunPayload $payload, array $expected): void
    {
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode($expected),
            actualJson: self::$serializer->serialize($payload, 'json')
        );
    }

    public function createRunDataProvider(): array
    {
        return [
            'basic_test' => [
                'payload' => (new CreateRunPayloadBuilder('assistant-one'))->getPayload(),
                'expected' => [
                    'assistant_id' => 'assistant-one',
                ]
            ]
        ];
    }
}