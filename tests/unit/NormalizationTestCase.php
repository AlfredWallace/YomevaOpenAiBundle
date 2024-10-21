<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Yomeva\OpenAiBundle\Exception\RecursionDepthException;

class NormalizationTestCase extends TestCase
{

    protected static SerializerInterface $serializer;

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

    protected function assertEqualsAssociativeArraysRecursive(array $expected, array $actual, int $depth = 0): void
    {
        if ($depth >= RecursionDepthException::MAX_DEPTH) {
            throw new RecursionDepthException();
        }

        // Check if arrays have the same size
        $this->assertSameSize($expected, $actual);

        // Check if arrays are not empty
        // No need to check if $actual is empty, because we now know they have the same size
        if (empty($expected)) {
            return;
        }

        foreach ($actual as $key => $value) {
            // check if all keys of $actual are in $expected
            // no need to check if all keys of $expected are in $actual because they have the same size
            $this->assertArrayHasKey($key, $expected);

            // if $actual[$key] ($value) is an array, then $expected[$key] has to be an array
            if (is_array($value)) {
                $this->assertIsArray($expected[$key]);

                // /!\ recursive /!\
                $this->assertEqualsAssociativeArraysRecursive($expected[$key], $value, $depth + 1);
            } else {
                $this->assertEquals($expected[$key], $value);
            }
        }
    }
}