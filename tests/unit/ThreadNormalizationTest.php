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
            ],
            'full_test___file_search_vector_store_ids' => [
                'payloadFunction' => function (ThreadPayloadBuilder $builder) {
                    return $builder
                        ->setCodeInterpreterToolResources(["file-id-1", "file-id-2"])
                        ->setFileSearchResources(["vector-id-1", "vector-id-2"])
                        ->setMetadata([
                            "foo" => "bar",
                            "bar" => "baz"
                        ])
                        ->addMetadata("baz", "qux");
                },
                'expected' => [
                    'tool_resources' => [
                        'code_interpreter' => [
                            'file_ids' => [
                                "file-id-1",
                                "file-id-2",
                            ]
                        ],
                        'file_search' => [
                            'vector_store_ids' => [
                                "vector-id-1",
                                "vector-id-2"
                            ]
                        ]
                    ],
                    "metadata" => [
                        "foo" => "bar",
                        "bar" => "baz",
                        "baz" => "qux"
                    ]
                ]
            ]
        ];
    }
}