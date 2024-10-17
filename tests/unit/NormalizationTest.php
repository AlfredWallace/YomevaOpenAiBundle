<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Yomeva\OpenAiBundle\Builder\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

class NormalizationTest extends YomevaOpenAiTestCase
{
    private static SerializerInterface $serializer;

    public static function setUpBeforeClass(): void
    {
        self::$serializer = new Serializer([
            new BackedEnumNormalizer(),
            new ObjectNormalizer(
                nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                defaultContext: [
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => true
                ]
            )
        ]);

        parent::setUpBeforeClass();
    }

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
            'full_test' => [
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
                    ]
                ]
            ]
        ];
    }
}