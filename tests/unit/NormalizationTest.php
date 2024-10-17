<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Yomeva\OpenAiBundle\Builder\CreateAssistantPayloadBuilder;
use Yomeva\OpenAiBundle\Model\Assistant\CreateAssistantPayload;

class NormalizationTest extends TestCase
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
        $this->assertEquals(
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
            ]
        ];
    }
}