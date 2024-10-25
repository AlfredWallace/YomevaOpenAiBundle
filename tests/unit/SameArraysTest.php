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

            'two_values_same_same_order' => [
                'left' => ["foo", "bar"],
                'right' => ["foo", "bar"],
                'expected' => true,
            ],

            'two_values_same_different_order' => [
                'left' => ["foo", "bar"],
                'right' => ["bar", "foo"],
                'expected' => true,
            ],

            'two_values_different' => [
                'left' => ["foo", "bar"],
                'right' => ["far", "bar"],
                'expected' => false,
            ],

            [
                'left' => [[]],
                'right' => [[]],
                'expected' => true,
            ],

            [
                'left' => [[]],
                'right' => [[null]],
                'expected' => false,
            ],

            [
                'left' => [[]],
                'right' => [[[]]],
                'expected' => false,
            ],

            [
                'left' => [[], [[]]],
                'right' => [[[]], []],
                'expected' => true,
            ],

            [
                'left' => ["test", "foo" => "bar", 42 => 1337],
                'right' => ["foo" => "bar", 1337, "test"],
                'expected' => true,
            ],

            [
                'left' => ["test", "foo" => "bar", "25" => 1337], // yes it is normal PHP behavior
                'right' => ["foo" => "bar", 1337, "test"],
                'expected' => true,
            ],

            [
                'left' => [
                    "foo" => "bar",
                    "baz",
                    10,
                    [
                        5,
                        "quz",
                        "hello" => [
                            "w",
                            0,
                            "r",
                            "l",
                            "d"
                        ]
                    ]
                ],
                'right' => [
                    23 => [
                        "hello" => [
                            "d",
                            0,
                            "r",
                            "l",
                            "w"
                        ],
                        5,
                        "quz"
                    ],
                    "10" => 10,
                    65 => "baz",
                    "foo" => "bar",
                ],
                'expected' => true,
            ]
        ];
    }
}