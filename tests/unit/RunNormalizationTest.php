<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Run\CreateRunPayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Run\ModifyRunPayloadBuilder;
use Yomeva\OpenAiBundle\Model\Content\Detail;
use Yomeva\OpenAiBundle\Model\Message\Role;
use Yomeva\OpenAiBundle\Model\Run\CreateRunPayload;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\Ranker;

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
            ],

            'test_full_base' => [
                'payload' => (new CreateRunPayloadBuilder('assistant-27'))
                    ->setModel('gpt-4o')
                    ->setInstructions("You have to do this and that")
                    ->setStream(false)
                    ->setMaxPromptTokens(20000)
                    ->setMaxCompletionTokens(17000)
                    ->setParallelToolCalls(true)
                    ->setMetadata([
                        "foo" => "bar",
                        "bar" => "baz",
                    ])
                    ->addMetadata("baz", "luhrman")
                    ->setTemperature(1.7)
                    ->setTopP(0.2)
                    ->setAdditionalInstructions("You also have to do this")
                    ->setAdditionalMessages([
                        (new CreateMessagePayloadBuilder(Role::User, "part one"))
                            ->addText("part two")
                            ->addImageFile("image-file-id", Detail::Low)
                            ->addImageUrl("image-url", Detail::High)
                            ->addAttachment("attachment-id", true, true)
                            ->addAttachment("attachment-id-2")
                            ->setMetadata([
                                "plop" => "kikoo"
                            ])
                            ->addMetadata("hello", "world")
                            ->getPayload()
                    ])
                    ->addAdditionalMessage(
                        (new CreateMessagePayloadBuilder(Role::Assistant, "Hello"))
                        ->getPayload()
                    )
                    ->getPayload(),
                'expected' => [
                    'assistant_id' => 'assistant-27',
                    'model' => 'gpt-4o',
                    'instructions' => 'You have to do this and that',
                    'stream' => false,
                    'max_prompt_tokens' => 20000,
                    'max_completion_tokens' => 17000,
                    'parallel_tool_calls' => true,
                    'metadata' => [
                        "foo" => "bar",
                        "bar" => "baz",
                        "baz" => "luhrman",
                    ],
                    'temperature' => 1.7,
                    'top_p' => 0.2,
                    'additional_instructions' => 'You also have to do this',
                    'additional_messages' => [
                        [
                            "role" => 'user',
                            "content" => [
                                [
                                    "type" => "text",
                                    "text" => "part one"
                                ],
                                [
                                    "type" => "text",
                                    "text" => "part two"
                                ],
                                [
                                    "type" => "image_file",
                                    "image_file" => [
                                        "file_id" => "image-file-id",
                                        "detail" => 'low',
                                    ],
                                ],
                                [
                                    "type" => "image_url",
                                    "image_url" => [
                                        "url" => "image-url",
                                        "detail" => 'high',
                                    ],
                                ]
                            ],
                            'attachments' => [
                                [
                                    "file_id" => "attachment-id",
                                    "tools" => [
                                        [
                                            "type" => "code_interpreter"
                                        ],
                                        [
                                            "type" => "file_search"
                                        ]
                                    ]
                                ],
                                [
                                    "file_id" => "attachment-id-2",
                                ]
                            ],
                            "metadata" => [
                                "plop" => "kikoo",
                                "hello" => "world"
                            ]
                        ],
                        [
                            'role' => 'assistant',
                            'content' => "Hello"
                        ]
                    ]
                ]
            ],

            'test_full_with_tools' => [
                'payload' => (new CreateRunPayloadBuilder('assistant-31'))
                    ->addFunctionTool(
                        "my-function",
                        "This function is awesome",
                        [
                            "type" => "object",
                            "properties" => [
                                "param-one" => [
                                    'type' => 'string',
                                    'description' => 'This is param one',
                                    'enum' => ['un', 'dos', 'tres']
                                ],
                                "param-two" => [
                                    'type' => 'integer',
                                    'description' => 'This is param two',
                                ]
                            ],
                            "required" => ['param-two'],
                            'additionalProperties' => false
                        ],
                        true
                    )
                    ->addCodeInterpreterTool()
                    ->addFileSearchTool(13, 0.4, Ranker::Default)
                    ->addCodeInterpreterTool()
                    ->getPayload(),
                'expected' => [
                    'assistant_id' => 'assistant-31',
                    'tools' => [
                        [
                            'type' => 'function',
                            'function' => [
                                'description' => 'This function is awesome',
                                'name' => 'my-function',
                                "parameters" => [
                                    "type" => "object",
                                    "properties" => [
                                        "param-one" => [
                                            'type' => 'string',
                                            'description' => 'This is param one',
                                            'enum' => ['un', 'dos', 'tres']
                                        ],
                                        "param-two" => [
                                            'type' => 'integer',
                                            'description' => 'This is param two',
                                        ]
                                    ],
                                    "required" => ['param-two'],
                                    'additionalProperties' => false
                                ],
                                'strict' => true
                            ],
                        ],
                        [
                            'type' => 'code_interpreter',
                        ],
                        [
                            'type' => 'file_search',
                            'file_search' => [
                                'max_num_results' => 13,
                                'ranking_options' => [
                                    'score_threshold' => 0.4,
                                    'ranker' => 'default_2024_08_21'
                                ]
                            ]
                        ],
                        [
                            'type' => 'code_interpreter',
                        ]
                    ]
                ]
            ]
        ];
    }
}