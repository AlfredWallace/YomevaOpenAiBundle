<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Yomeva\OpenAiBundle\Builder\SerializerBuilder;
use Yomeva\OpenAiBundle\Exception\RecursionDepthException;

abstract class NormalizationTestCase extends TestCase
{
    protected static SerializerInterface $serializer;

    public static function setUpBeforeClass(): void
    {
        self::$serializer = (new SerializerBuilder())->makeSerializer();

        parent::setUpBeforeClass();
    }

    protected function assertSameArrays(array $expected, array $actual, int $depth = 0): void
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

        [$integerIndexedActual, $stringIndexedActual] = $this->splitArrayByKeyType($actual);
        [$integerIndexedExpected, $stringIndexedExpected] = $this->splitArrayByKeyType($expected);

        $this->assertIntegerIndexedSame($integerIndexedActual, $integerIndexedExpected);
        $this->assertStringIndexedSame($stringIndexedExpected, $stringIndexedActual, $depth + 1);
    }

    private function assertIntegerIndexedSame(array $expected, array $actual): void
    {
        $this->assertSameSize($expected, $actual);

        $this->sortIntegerIndexed($actual);
        $this->sortIntegerIndexed($expected);

        $this->assertSame($expected, $actual);
    }

    private function assertStringIndexedSame(array $expected, array $actual, int $depth): void
    {
        $this->assertSameSize($expected, $actual);

        foreach ($actual as $key => $value) {
            $this->assertArrayHasKey($key, $expected);

            if (is_array($value)) {
                $this->assertIsArray($expected[$key]);
                $this->assertStringIndexedSame($value, $expected[$key], $depth + 1);
            } else {
                $this->assertSame($value, $expected[$key]);
            }
        }
    }

    private function splitArrayByKeyType(array $array): array
    {
        $numeric = [];
        $assoc = [];

        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $numeric[] = $value;
            } else {
                $assoc[$key] = $value;
            }
        }

        return [$numeric, $assoc];
    }

    private function sortIntegerIndexed(array &$array, int $depth = 0): void
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->sortIntegerIndexed($value, $depth + 1);
            }
        }
        sort($array);
    }
}