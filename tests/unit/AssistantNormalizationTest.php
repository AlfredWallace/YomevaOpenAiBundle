<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\AssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Assistant\ModifyAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\ChunkingStrategy;
use Yomeva\OpenAiBundle\Builder\Payload\Tool\FileSearchVectorStoreBuilder;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

class AssistantNormalizationTest extends NormalizationTestCase
{
    /**
     * @dataProvider assistantData
     * @throws ExceptionInterface
     */
    public function testCreateAssistant(callable $payloadFunction, array $expected): void
    {
        $this->assertEqualsAssociativeArraysRecursive(
            expected: $expected,
            actual: self::$serializer->normalize(
                $payloadFunction(new CreateAssistantPayloadBuilder('gpt-4o'))->getPayload()
            ),
        );
    }

    /**
     * @dataProvider assistantData
     * @throws ExceptionInterface
     */
    public function testModifyAssistant(callable $payloadFunction, array $expected): void
    {
        $this->assertEqualsAssociativeArraysRecursive(
            expected: $expected,
            actual: self::$serializer->normalize(
                $payloadFunction(new ModifyAssistantPayloadBuilder())->setModel('gpt-4o')->getPayload()
            ),
        );
    }

    public function assistantData(): array
    {
        return [
            'basic_test' => [
                'payloadFunction' => (function (AssistantPayloadBuilder $builder) {
                    return $builder;
                }),
                'expected' => [
                    'model' => 'gpt-4o'
                ],
            ],

            'full_test___file_search_vector_store_ids___no_response_format' => [
                'payloadFunction' =>
                    function (AssistantPayloadBuilder $builder) {
                        return $builder
                            ->setName('My new assistant')
                            ->setDescription("Description de l'assistant")
                            ->setInstructions("Tu es un assistant d'assistanat")
                            ->addCodeInterpreterTool()
                            ->addFileSearchTool(25, 0.5, Ranker::Default)
                            ->addFunctionTool(
                                'Ma super fonction',
                                'Elle fait plein de choses',
                                [
                                    "type" => "object",
                                    "properties" => [
                                        "arg1" => [
                                            'type' => 'string',
                                            'description' => 'Argument 1',
                                            'enum' => ['one', 'two', 'three']
                                        ],
                                        "arg2" => [
                                            'type' => 'integer',
                                            'description' => 'Argument 2',
                                        ]
                                    ],
                                    "required" => ['arg1'],
                                    'additionalProperties' => false
                                ],
                                false
                            )
                            ->setCodeInterpreterToolResources(["file-id-1", "file-id-2"])
                            ->setFileSearchResources(["vector-store-id-1", "vector-store-id-2"])
                            ->setMetadata([
                                "foo" => "bar",
                                "hello" => "world"
                            ])
                            ->addMetadata("afp", "was here")
                            ->setTemperature(1.2)
                            ->setTopP(0.3);
                    },
                'expected' => [
                    'model' => 'gpt-4o',
                    'name' => 'My new assistant',
                    'description' => "Description de l'assistant",
                    'instructions' => "Tu es un assistant d'assistanat",
                    'tools' => [
                        [
                            'type' => 'code_interpreter'
                        ],
                        [
                            'type' => 'file_search',
                            'file_search' => [
                                'max_num_results' => 25,
                                'ranking_options' => [
                                    'score_threshold' => 0.5,
                                    'ranker' => Ranker::Default->value
                                ]
                            ]
                        ],
                        [
                            'type' => 'function',
                            'function' => [
                                'name' => 'Ma super fonction',
                                'description' => 'Elle fait plein de choses',
                                'parameters' => [
                                    "type" => "object",
                                    "properties" => [
                                        "arg1" => [
                                            'type' => 'string',
                                            'description' => 'Argument 1',
                                            'enum' => ['one', 'two', 'three']
                                        ],
                                        "arg2" => [
                                            'type' => 'integer',
                                            'description' => 'Argument 2',
                                        ]
                                    ],
                                    "required" => ['arg1'],
                                    'additionalProperties' => false
                                ],
                                'strict' => false
                            ]
                        ],
                    ],
                    'tool_resources' => [
                        'code_interpreter' => [
                            'file_ids' => [
                                "file-id-1",
                                "file-id-2",
                            ]
                        ],
                        "file_search" => [
                            "vector_store_ids" => [
                                "vector-store-id-1",
                                "vector-store-id-2",
                            ]
                        ]
                    ],
                    "metadata" => [
                        "foo" => "bar",
                        "hello" => "world",
                        "afp" => "was here"
                    ],
                    "temperature" => 1.2,
                    "top_p" => 0.3
                ]
            ],

            'full_test___file_search_vector_stores___no_response_format' => [
                'payload' =>
                    function (AssistantPayloadBuilder $builder) {
                        return $builder
                            ->setName('My new assistant')
                            ->setDescription("Description de l'assistant")
                            ->setInstructions("Tu es un assistant d'assistanat")
                            ->addCodeInterpreterTool()
                            ->addFileSearchTool(25, 0.5, Ranker::Default)
                            ->addFunctionTool(
                                'Ma super fonction',
                                'Elle fait plein de choses',
                                [
                                    "type" => "object",
                                    "properties" => [
                                        "arg1" => [
                                            'type' => 'string',
                                            'description' => 'Argument 1',
                                            'enum' => ['one', 'two', 'three']
                                        ],
                                        "arg2" => [
                                            'type' => 'integer',
                                            'description' => 'Argument 2',
                                        ]
                                    ],
                                    "required" => ['arg1'],
                                    'additionalProperties' => false
                                ],
                                false
                            )
                            ->setCodeInterpreterToolResources(["file-id-1", "file-id-2"])
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
                                "foo" => "bar",
                                "hello" => "world"
                            ])
                            ->addMetadata("afp", "was here")
                            ->setTemperature(1.2)
                            ->setTopP(0.3);
                    },
                'expected' => [
                    'model' => 'gpt-4o',
                    'name' => 'My new assistant',
                    'description' => "Description de l'assistant",
                    'instructions' => "Tu es un assistant d'assistanat",
                    'tools' => [
                        [
                            'type' => 'code_interpreter'
                        ],
                        [
                            'type' => 'file_search',
                            'file_search' => [
                                'max_num_results' => 25,
                                'ranking_options' => [
                                    'score_threshold' => 0.5,
                                    'ranker' => Ranker::Default->value
                                ]
                            ]
                        ],
                        [
                            'type' => 'function',
                            'function' => [
                                'name' => 'Ma super fonction',
                                'description' => 'Elle fait plein de choses',
                                'parameters' => [
                                    "type" => "object",
                                    "properties" => [
                                        "arg1" => [
                                            'type' => 'string',
                                            'description' => 'Argument 1',
                                            'enum' => ['one', 'two', 'three']
                                        ],
                                        "arg2" => [
                                            'type' => 'integer',
                                            'description' => 'Argument 2',
                                        ]
                                    ],
                                    "required" => ['arg1'],
                                    'additionalProperties' => false
                                ],
                                'strict' => false
                            ]
                        ],
                    ],
                    'tool_resources' => [
                        'code_interpreter' => [
                            'file_ids' => [
                                "file-id-1",
                                "file-id-2",
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
                    "metadata" => [
                        "foo" => "bar",
                        "hello" => "world",
                        "afp" => "was here"
                    ],
                    "temperature" => 1.2,
                    "top_p" => 0.3
                ]
            ],

            'full_test___response_format_auto' => [
                'payload' =>
                    function (AssistantPayloadBuilder $builder) {
                        return $builder
                            ->setName('My new assistant')
                            ->setDescription("Description de l'assistant")
                            ->setInstructions("Tu es un assistant d'assistanat")
                            ->addCodeInterpreterTool()
                            ->addFileSearchTool(25, 0.5, Ranker::Default)
                            ->addFunctionTool(
                                name: 'Ma super fonction',
                                strict: true
                            )
                            ->setMetadata([
                                "foo" => "bar",
                                "hello" => "world"
                            ])
                            ->addMetadata("afp", "was here")
                            ->setTemperature(1.2)
                            ->setTopP(0.3)
                            ->setResponseFormatToAuto();
                    },
                'expected' => [
                    'model' => 'gpt-4o',
                    'name' => 'My new assistant',
                    'description' => "Description de l'assistant",
                    'instructions' => "Tu es un assistant d'assistanat",
                    'tools' => [
                        [
                            'type' => 'code_interpreter'
                        ],
                        [
                            'type' => 'file_search',
                            'file_search' => [
                                'max_num_results' => 25,
                                'ranking_options' => [
                                    'score_threshold' => 0.5,
                                    'ranker' => Ranker::Default->value
                                ]
                            ]
                        ],
                        [
                            'type' => 'function',
                            'function' => [
                                'name' => 'Ma super fonction',
                                'strict' => true
                            ]
                        ],
                    ],
                    "metadata" => [
                        "foo" => "bar",
                        "hello" => "world",
                        "afp" => "was here"
                    ],
                    "temperature" => 1.2,
                    "top_p" => 0.3,
                    "response_format" => "auto",
                ]
            ],

            'full_test___response_format_text' => [
                'payload' =>
                    function (AssistantPayloadBuilder $builder) {
                        return $builder
                            ->setName('My new assistant')
                            ->setDescription("Description de l'assistant")
                            ->setInstructions("Tu es un assistant d'assistanat")
                            ->addCodeInterpreterTool()
                            ->addFileSearchTool(25, 0.5, Ranker::Default)
                            ->addFunctionTool(
                                name: 'Ma super fonction',
                                strict: true
                            )
                            ->setMetadata([
                                "foo" => "bar",
                                "hello" => "world"
                            ])
                            ->addMetadata("afp", "was here")
                            ->setTemperature(1.2)
                            ->setTopP(0.3)
                            ->setResponseFormatToText();
                    },
                'expected' => [
                    'model' => 'gpt-4o',
                    'name' => 'My new assistant',
                    'description' => "Description de l'assistant",
                    'instructions' => "Tu es un assistant d'assistanat",
                    'tools' => [
                        [
                            'type' => 'code_interpreter'
                        ],
                        [
                            'type' => 'file_search',
                            'file_search' => [
                                'max_num_results' => 25,
                                'ranking_options' => [
                                    'score_threshold' => 0.5,
                                    'ranker' => Ranker::Default->value
                                ]
                            ]
                        ],
                        [
                            'type' => 'function',
                            'function' => [
                                'name' => 'Ma super fonction',
                                'strict' => true
                            ]
                        ],
                    ],
                    "metadata" => [
                        "foo" => "bar",
                        "hello" => "world",
                        "afp" => "was here"
                    ],
                    "temperature" => 1.2,
                    "top_p" => 0.3,
                    "response_format" => [
                        "type" => "text"
                    ],
                ]
            ],

            'full_test___response_format_json_object' => [
                'payload' =>
                    function (AssistantPayloadBuilder $builder) {
                        return $builder
                            ->setName('My new assistant')
                            ->setDescription("Description de l'assistant")
                            ->setInstructions("Tu es un assistant d'assistanat")
                            ->addFunctionTool(
                                name: 'Ma super fonction',
                                strict: true
                            )
                            ->setMetadata([
                                "foo" => "bar",
                                "hello" => "world"
                            ])
                            ->addMetadata("afp", "was here")
                            ->setTemperature(1.2)
                            ->setTopP(0.3)
                            ->setResponseFormatToJsonObject();
                    },
                'expected' => [
                    'model' => 'gpt-4o',
                    'name' => 'My new assistant',
                    'description' => "Description de l'assistant",
                    'instructions' => "Tu es un assistant d'assistanat",
                    'tools' => [
                        [
                            'type' => 'function',
                            'function' => [
                                'name' => 'Ma super fonction',
                                'strict' => true
                            ]
                        ],
                    ],
                    "metadata" => [
                        "foo" => "bar",
                        "hello" => "world",
                        "afp" => "was here"
                    ],
                    "temperature" => 1.2,
                    "top_p" => 0.3,
                    "response_format" => [
                        "type" => "json_object"
                    ],
                ]
            ],

            'full_test___response_format_json_schema' => [
                'payload' =>
                    function (AssistantPayloadBuilder $builder) {
                        return $builder
                            ->setName('My new assistant')
                            ->setDescription("Description de l'assistant")
                            ->setInstructions("Tu es un assistant d'assistanat")
                            ->addFunctionTool(
                                name: 'Ma super fonction',
                                strict: true
                            )
                            ->setMetadata([
                                "foo" => "bar",
                                "hello" => "world"
                            ])
                            ->addMetadata("afp", "was here")
                            ->setTemperature(1.2)
                            ->setTopP(0.3)
                            ->setResponseFormatToJsonSchema(
                                "schema name schema name",
                                [
                                    "type" => "object",
                                    "properties" => ["arg1" => ["type" => "string"], "arg2" => ["type" => "integer"]],
                                    "required" => ["arg1"],
                                    "additionalProperties" => false
                                ],
                                "this is a famous song",
                                true
                            );
                    },
                'expected' => [
                    'model' => 'gpt-4o',
                    'name' => 'My new assistant',
                    'description' => "Description de l'assistant",
                    'instructions' => "Tu es un assistant d'assistanat",
                    'tools' => [
                        [
                            'type' => 'function',
                            'function' => [
                                'name' => 'Ma super fonction',
                                'strict' => true
                            ]
                        ],
                    ],
                    "metadata" => [
                        "foo" => "bar",
                        "hello" => "world",
                        "afp" => "was here"
                    ],
                    "temperature" => 1.2,
                    "top_p" => 0.3,
                    "response_format" => [
                        "type" => "json_schema",
                        "json_schema" => [
                            "name" => "schema name schema name",
                            "description" => "this is a famous song",
                            "schema" => [
                                "type" => "object",
                                "properties" => ["arg1" => ["type" => "string"], "arg2" => ["type" => "integer"]],
                                "required" => ["arg1"],
                                "additionalProperties" => false
                            ],
                            "strict" => true
                        ]
                    ],
                ]
            ]
        ];
    }
}