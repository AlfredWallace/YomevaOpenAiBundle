<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use Yomeva\OpenAiBundle\Builder\Payload\Message\CreateMessagePayloadBuilder;
use Yomeva\OpenAiBundle\Builder\Payload\Message\ModifyMessagePayloadBuilder;
use Yomeva\OpenAiBundle\Model\Content\Detail;
use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Model\Message\ModifyMessagePayload;
use Yomeva\OpenAiBundle\Model\Message\Role;

final class MessageNormalizationTest extends NormalizationTestCase
{
    /**
     * @dataProvider createMessageDataProvider
     */
    public function testCreateMessage(CreateMessagePayload $payload, array $expected): void
    {
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode($expected),
            actualJson: self::$serializer->serialize($payload, 'json')
        );
    }

    /**
     * @dataProvider modifyMessageDataProvider
     */
    public function testModifyMessage(ModifyMessagePayload $payload, array $expected): void
    {
        $this->assertJsonStringEqualsJsonString(
            expectedJson: json_encode($expected),
            actualJson: self::$serializer->serialize($payload, 'json')
        );
    }

    public function createMessageDataProvider(): array
    {
        return [
            'basic_test' => [
                'payload' => (new CreateMessagePayloadBuilder(Role::User))->getPayload(),
                'expected' => [
                    'role' => Role::User->value,
                    'content' => []
                ]
            ],
            'full_test___string_content' => [
                'payload' => (new CreateMessagePayloadBuilder(Role::Assistant, "Mon message de base"))
                    ->addText("Un autre message textuel")
                    ->addImageFile("file-id-1", Detail::High)
                    ->addImageFile("file-id-2", Detail::Auto)
                    ->addImageUrl("image-url-1")
                    ->addImageUrl("image-url-2", Detail::Low)
                    ->addAttachment("attachment-id-1")
                    ->addAttachment("attachment-id-2", useCodeInterpreter: true)
                    ->addAttachment("attachment-id-3", useFileSearch: true)
                    ->addAttachment("attachment-id-4", useCodeInterpreter: true, useFileSearch: true)
                    // todo metadata
                    ->getPayload(),
                'expected' => [
                    'role' => Role::Assistant->value,
                    'content' => [
                        [
                            "type" => "text",
                            "text" => "Mon message de base"
                        ],
                        [
                            "type" => "text",
                            "text" => "Un autre message textuel"
                        ],
                        [
                            "type" => "image_file",
                            "image_file" => [
                                "file_id" => "file-id-1",
                                "detail" => Detail::High->value,
                            ]
                        ],
                        [
                            "type" => "image_file",
                            "image_file" => [
                                "file_id" => "file-id-2",
                                "detail" => Detail::Auto->value,
                            ]
                        ],
                        [
                            "type" => "image_url",
                            "image_url" => [
                                "url" => "image-url-1",
                            ]
                        ],
                        [
                            "type" => "image_url",
                            "image_url" => [
                                "url" => "image-url-2",
                                "detail" => Detail::Low->value,
                            ]
                        ]
                    ],
                    'attachments' => [
                        [
                            "file_id" => "attachment-id-1",
                        ],
                        [
                            "file_id" => "attachment-id-2",
                            "tools" => [
                                [
                                    "type" => "code_interpreter",
                                ]
                            ]
                        ],
                        [
                            "file_id" => "attachment-id-3",
                            "tools" => [
                                [
                                    "type" => "file_search",
                                ]
                            ]
                        ],
                        [
                            "file_id" => "attachment-id-4",
                            "tools" => [
                                [
                                    "type" => "code_interpreter",
                                ],
                                [
                                    "type" => "file_search",
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ];
    }

    public function modifyMessageDataProvider(): array
    {
        return [
            'basic_test' => [
                'payload' => (new ModifyMessagePayloadBuilder())->getPayload(),
                'expected' => []
            ],
            'full_test' => [
                'payload' => (new ModifyMessagePayloadBuilder())
                    ->setMetadata([
                        "foo" => "bar",
                        "bar" => "baz"
                    ])
                    ->addMetadata("baz", "quz")
                    ->getPayload(),
                'expected' => [
                    'metadata' => [
                        "foo" => "bar",
                        "bar" => "baz",
                        "baz" => "quz"
                    ]
                ]
            ]
        ];
    }
}