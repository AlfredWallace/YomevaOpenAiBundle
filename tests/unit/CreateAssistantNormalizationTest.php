<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Yomeva\OpenAiBundle\Builder\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

class CreateAssistantNormalizationTest extends NormalizationTestCase
{
    /**
     * @dataProvider createAssistantProvider
     * @throws ExceptionInterface
     */
    public function testCreateAssistant(CreateAssistantPayload $payload, array $expected): void
    {
        $this->assertEqualsAssociativeArraysRecursive(
            expected: $expected,
            actual: self::$serializer->normalize($payload)
        );
    }

    public function createAssistantProvider(): array
    {
        return [
            'basic_test' => [
                'payload' => (new CreateAssistantPayloadBuilder('gpt-4o'))->getPayload(),
                'expected' => [
                    'model' => 'gpt-4o'
                ],
            ],

            'full_test___file_search_vector_store_ids___no_response_format' => [
                'payload' =>
                    (new CreateAssistantPayloadBuilder('gpt-4o'))
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
                        ->setTopP(0.3)
                        ->getPayload(),
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
            ]
        ];
    }
}