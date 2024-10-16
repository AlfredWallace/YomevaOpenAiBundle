<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Yomeva\OpenAiBundle\Exception\RecursionDepthException;

class YomevaOpenAiTestCase extends TestCase
{
    protected function assertEqualsAssociativeArraysRecursive(array $expected, array $actual, int $depth = 0): void
    {
        if ($depth >= 100) {
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

            // if $actual[$key] is an array, then $expected[$key] has to be an array
            if (is_array($value)) {
                $this->assertIsArray($expected[$key]);
                $this->assertEqualsAssociativeArraysRecursive($expected[$key], $value, $depth + 1);
            } else {
                $this->assertEquals($expected[$key], $value);
            }
        }
    }
}