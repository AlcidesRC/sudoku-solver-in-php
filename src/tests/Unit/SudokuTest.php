<?php

namespace UnitTests;

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;
use App\Sudoku;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class SudokuTest extends TestCase
{
    /**
     * @param array<int, array<int, int>> $map
     * @param array<int, array<int, int>> $expectedSolution
     *
     * @covers \App\Sudoku::findEmptyCell
     * @covers \App\Sudoku::hasValidSchema
     * @covers \App\Sudoku::isCandidateTaken
     * @covers \App\Sudoku::solve
     * @covers \App\Sudoku::solveRecursively
     *
     * @dataProvider dataProviderSudokuHappyPath
     */
    public function testHappyPath(array $map, array $expectedSolution): void
    {
        $sudoku = new Sudoku();
        $sudoku->solve($map);

        static::assertSame($expectedSolution, $sudoku->map);
    }

    /**
     * @return array<int, array<int, array<int, array<int, int>>>>
     */
    public function dataProviderSudokuHappyPath(): array
    {
        return [
            [
                [
                    [8, 0, 0,    0, 0, 0,    0, 0, 0],
                    [0, 0, 3,    6, 0, 0,    0, 0, 0],
                    [0, 7, 0,    0, 9, 0,    2, 0, 0],

                    [0, 5, 0,    0, 0, 7,    0, 0, 0],
                    [0, 0, 0,    0, 4, 5,    7, 0, 0],
                    [0, 0, 0,    1, 0, 0,    0, 3, 0],

                    [0, 0, 1,    0, 0, 0,    0, 6, 8],
                    [0, 0, 8,    5, 0, 0,    0, 1, 0],
                    [0, 9, 0,    0, 0, 0,    4, 0, 0],
                ],
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
     * @covers \App\Sudoku::hasValidSchema
     * @covers \App\Sudoku::solve
     *
     * @dataProvider dataProviderSudokuThrowExceptionWithWrongSchema
     */
    public function testThrowExceptionWithWrongSchema(array $map): void
    {
        $this->expectException(WrongSchemaException::class);

        (new Sudoku())
            ->solve($map);
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

    /**
     * @param array<int, array<int, int>> $map
     *
     * @covers \App\Exceptions\CannotBeSolvedException::__construct
     * @covers \App\Sudoku::findEmptyCell
     * @covers \App\Sudoku::hasValidSchema
     * @covers \App\Sudoku::isCandidateTaken
     * @covers \App\Sudoku::solve
     * @covers \App\Sudoku::solveRecursively
     *
     * @dataProvider dataProviderSudokuThrowExceptionWithWrongContents
     */
    public function testThrowExceptionWithWrongContents(array $map): void
    {
        $this->expectException(CannotBeSolvedException::class);

        (new Sudoku())
            ->solve($map);
    }

    /**
     * @return array<int, array<int, array<int, array<int, int>>>>
     */
    public function dataProviderSudokuThrowExceptionWithWrongContents(): array
    {
        return [
            [
                [
                    [8, 8, 8,    0, 0, 0,    0, 0, 0],
                    [0, 0, 3,    6, 0, 0,    0, 0, 0],
                    [0, 7, 0,    0, 9, 0,    2, 0, 0],

                    [0, 5, 0,    0, 0, 7,    0, 0, 0],
                    [0, 0, 0,    0, 4, 5,    7, 0, 0],
                    [0, 0, 0,    1, 0, 0,    0, 3, 0],

                    [0, 0, 1,    0, 0, 0,    0, 6, 8],
                    [0, 0, 8,    5, 0, 0,    0, 1, 0],
                    [0, 9, 0,    0, 0, 0,    4, 0, 0],
                ],
            ],
        ];
    }

    /**
     * @param array<int, array<int, int>> $solution
     *
     * @covers \App\Sudoku::asCli
     * @covers \App\Sudoku::fillTemplate
     *
     * @dataProvider dataProviderSudokuSolved
     */
    public function testRenderSudokuAsCli(array $solution): void
    {
        $sudoku = new Sudoku();
        $sudoku->map = $solution;

        $output = $sudoku->asCli();

        static::assertIsString($output);
        static::assertNotEmpty($output);
        static::assertStringStartsWith('┏━━━━━━━━━━━┳━━━━━━━━━━━┳━━━━━━━━━━━┓', $output);
        static::assertStringEndsWith('┗━━━━━━━━━━━┻━━━━━━━━━━━┻━━━━━━━━━━━┛' . PHP_EOL, $output);
        static::assertStringNotContainsString('CA', $output);
        static::assertStringNotContainsString('CB', $output);
        static::assertStringNotContainsString('R', $output);
    }

    /**
     * @param array<int, array<int, int>> $solution
     *
     * @covers \App\Sudoku::asHtml
     * @covers \App\Sudoku::fillTemplate
     *
     * @dataProvider dataProviderSudokuSolved
     */
    public function testRenderSudokuAsHtml(array $solution): void
    {
        $sudoku = new Sudoku();
        $sudoku->map = $solution;

        $output = $sudoku->asHtml();

        static::assertIsString($output);
        static::assertNotEmpty($output);
        static::assertStringStartsWith('<div id="sudoku" style="font-family:monospace;">', $output);
        static::assertStringEndsWith('</div>', $output);
        static::assertStringNotContainsString('CA', $output);
        static::assertStringNotContainsString('CB', $output);
        static::assertStringNotContainsString('R', $output);
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
}
