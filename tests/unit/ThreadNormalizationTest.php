<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Yomeva\OpenAiBundle\Builder\Payload\Thread\CreateThreadPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\ModifyThreadPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Thread\ThreadPayloadBuilderInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\ChunkingStrategy;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\FileSearchVectorStoreBuilder;

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
                'payloadFunction' => function (ThreadPayloadBuilderInterface $builder) {
                    return $builder;
                },
                'expected' => []
            ],

            'full_test___file_search_vector_store_ids' => [
                'payloadFunction' => function (ThreadPayloadBuilderInterface $builder) {
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
            ],

            'full_test___file_search_vector_stores' => [
                'payloadFunction' => function (ThreadPayloadBuilderInterface $builder) {
                    return $builder
                        ->setCodeInterpreterToolResources(["file-id-3", "file-id-4"])
                        ->setFileSearchResources(
                            vectorStores: [
                                (new FileSearchVectorStoreBuilder())->getVectorStore(),
                                (new FileSearchVectorStoreBuilder(
                                    ["file-id-1", "file-id-2"]
                                ))->getVectorStore(),
                                (new FileSearchVectorStoreBuilder(
                                    strategy: ChunkingStrategy::Auto
                                ))->getVectorStore(),
                                (new FileSearchVectorStoreBuilder(
                                    strategy: ChunkingStrategy::Static
                                ))->getVectorStore(),
                                (new FileSearchVectorStoreBuilder(
                                    strategy: ChunkingStrategy::Static,
                                    maxChunkSizeTokens: 255,
                                    chunkOverlapTokens: 128
                                ))->getVectorStore(),
                                (new FileSearchVectorStoreBuilder(
                                    fileIds: ["file-id-3", "file-id-4"],
                                    strategy: ChunkingStrategy::Static,
                                    maxChunkSizeTokens: 900,
                                    chunkOverlapTokens: 300,
                                    metadata: [
                                        "foo" => "bar",
                                        "hello" => "world",
                                        "afp" => "was here"
                                    ]
                                ))->getVectorStore()
                            ]
                        )
                        ->setMetadata([
                            "bon" => "jour",
                            "au" => "revoir"
                        ])
                        ->addMetadata("ça", "va");
                },
                'expected' => [
                    'tool_resources' => [
                        "code_interpreter" => [
                            'file_ids' => [
                                "file-id-3",
                                "file-id-4",
                            ]
                        ],
                        "file_search" => [
                            "vector_stores" => [
                                [],
                                ["file_ids" => ["file-id-1", "file-id-2"]],
                                [
                                    "chunking_strategy" =>
                                        [
                                            "type" => "auto"
                                        ]
                                ],
                                [
                                    "chunking_strategy" => [
                                        "type" => "static",
                                        "static" => []
                                    ]
                                ],
                                [
                                    "chunking_strategy" => [
                                        "type" => "static",
                                        "static" => [
                                            "max_chunk_size_tokens" => 255,
                                            "chunk_overlap_tokens" => 128
                                        ]
                                    ]
                                ],
                                [
                                    "file_ids" => ["file-id-3", "file-id-4"],
                                    "chunking_strategy" => [
                                        "type" => "static",
                                        "static" => [
                                            "max_chunk_size_tokens" => 900,
                                            "chunk_overlap_tokens" => 300
                                        ]
                                    ],
                                    "metadata" => [
                                        "foo" => "bar",
                                        "hello" => "world",
                                        "afp" => "was here"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'metadata' => [
                        "bon" => "jour",
                        "au" => "revoir",
                        "ça" => "va"
                    ]
                ]
            ]
        ];
    }
}