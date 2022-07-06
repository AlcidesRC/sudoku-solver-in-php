<?php

namespace UnitTests;

use App\Exceptions\WrongSchemaException;
use App\SudokuRenderCli;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class SudokuRenderCliTest extends TestCase
{
    /**
     * @param array<int, array<int, int>> $map
     *
     * @covers \App\SudokuRenderCli::render
     * @covers \App\SudokuRenderCli::checkSchema
     * @covers \App\SudokuRenderCli::getTemplate
     * @covers \App\SudokuRenderCli::getValuesReplacements
     *
     * @dataProvider dataProviderSudokuSolved
     */
    public function testHappyPath(array $map): void
    {
        $output = (new SudokuRenderCli())->render($map);

        static::assertIsString($output);
        static::assertNotEmpty($output);
        static::assertStringNotContainsString('CA', $output);
        static::assertStringNotContainsString('CB', $output);
        static::assertStringNotContainsString('R', $output);
        static::assertStringStartsWith(SudokuRenderCli::STARTS_WITH, $output);
        static::assertStringEndsWith(SudokuRenderCli::ENDS_WITH, $output);
    }

    /**
     * @return array<int, array<int, array<int, array<int, int>>>>
     */
    public function dataProviderSudokuSolved(): array
    {
        return [
            [
                [
                    [8, 1, 2,    7, 5, 3,    6, 4, 9],
                    [9, 4, 3,    6, 8, 2,    1, 7, 5],
                    [6, 7, 5,    4, 9, 1,    2, 8, 3],

                    [1, 5, 4,    2, 3, 7,    8, 9, 6],
                    [3, 6, 9,    8, 4, 5,    7, 2, 1],
                    [2, 8, 7,    1, 6, 9,    5, 3, 4],

                    [5, 2, 1,    9, 7, 4,    3, 6, 8],
                    [4, 3, 8,    5, 2, 6,    9, 1, 7],
                    [7, 9, 6,    3, 1, 8,    4, 5, 2],
                ],
            ],
        ];
    }

    /**
     * @param array<int, array<int, int>> $map
     *
     * @covers \App\Exceptions\WrongSchemaException::__construct
     * @covers \App\SudokuRenderCli::render
     * @covers \App\SudokuRenderCli::checkSchema
     *
     * @dataProvider dataProviderSudokuThrowExceptionWithWrongSchema
     */
    public function testThrowExceptionWithWrongSchema(array $map): void
    {
        $this->expectException(WrongSchemaException::class);

        (new SudokuRenderCli())
            ->render($map);
    }

    /**
     * @return array<int, array<int, array<int, array<int, null|float|int|string>>>>
     */
    public function dataProviderSudokuThrowExceptionWithWrongSchema(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    [1, 0, 0],
                ],
            ],
            [
                [
                    [1, 0, 0,    0, 0, 0,    0, 0, 0],
                ],
            ],
            [
                [
                    [1, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0],
                    [0],

                    [0],
                    [0],
                    [0],

                    [0],
                    [0],
                    [0],
                ],
            ],
            [
                [
                    [-1, 0, 0,   0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                ],
            ],
            [
                [
                    [11, 0, 0,   0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                ],
            ],
            [
                [
                    ['A', 0, 0,   0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                ],
            ],
            [
                [
                    [null, 0, 0,   0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                ],
            ],
            [
                [
                    [9.0, 0, 0,   0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],

                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 0,    0, 0, 0,    0, 0, 0],
                ],
            ],
        ];
    }
}
