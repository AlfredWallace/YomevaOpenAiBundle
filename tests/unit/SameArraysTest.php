<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

class SameArraysTest extends NormalizationTestCase
{
    /**
     * @dataProvider arrayProvider
     */
    public function testSameArrays(array $left, array $right, bool $expected): void
    {
        try {
            $this->assertSameArrays($left, $right);
            $same = true;
        } catch (\Throwable $throwable) {
            $same = false;
        }

        $this->assertSame($expected, $same);
    }

    public function arrayProvider(): array
    {
        return [
            'all_empty' => [
                'left' => [],
                'right' => [],
                'expected' => true,
            ],

            'left_empty' => [
                'left' => [],
                'right' => ["dummy"],
                'expected' => false,
            ],

            'right_empty' => [
                'left' => ["dummy"],
                'right' => [],
                'expected' => false,
            ],

            'one_value_null' => [
                'left' => [null],
                'right' => [null],
                'expected' => true,
            ],

            'one_value_string_same' => [
                'left' => ["dummy"],
                'right' => ["dummy"],
                'expected' => true,
            ],

            'one_value_string_different' => [
                'left' => ["foo"],
                'right' => ["bar"],
                'expected' => false,
            ],

            'one_value_int_same' => [
                'left' => [42],
                'right' => [42],
                'expected' => true,
            ],

            'one_value_int_different' => [
                'left' => [42],
                'right' => [1337],
                'expected' => false,
            ],

            'one_value_float_same' => [
                'left' => [4.2],
                'right' => [4.2],
                'expected' => true,
            ],

            'one_value_float_different' => [
                'left' => [4.2],
                'right' => [13.37],
                'expected' => false,
            ],

            'one_value_bool_same' => [
                'left' => [true],
                'right' => [true],
                'expected' => true,
            ],

            'one_value_bool_different' => [
                'left' => [true],
                'right' => [false],
                'expected' => false,
            ],

            'one_value_different_types_1' => [
                'left' => [true],
                'right' => [1],
                'expected' => false,
            ],

            'one_value_different_types_2' => [
                'left' => ["foo"],
                'right' => [4.2],
                'expected' => false,
            ],

            'one_value_different_types_3' => [
                'left' => [true],
                'right' => [0],
                'expected' => false,
            ],

            'one_value_different_types_4' => [
                'left' => [1],
                'right' => [false],
                'expected' => false,
            ],

            'one_value_different_types_5' => [
                'left' => [1],
                'right' => [1.0],
                'expected' => false,
            ],

            'one_value_different_types_6' => [
                'left' => [0],
                'right' => [null],
                'expected' => false,
            ],
        ];
    }
}