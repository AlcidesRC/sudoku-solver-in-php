<?php

namespace UnitTests;

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;
use App\SudokuSolver;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class SudokuSolverTest extends TestCase
{
    /**
     * @param array<int, array<int, int|string>> $map
     * @param array<int, array<int, int>> $expectedSolution
     *
     * @covers \App\SudokuSolver::pickFirstEmptyCell
     * @covers \App\SudokuSolver::checkSchema
     * @covers \App\SudokuSolver::getCandidates
     * @covers \App\SudokuSolver::getColValues
     * @covers \App\SudokuSolver::getRowValues
     * @covers \App\SudokuSolver::getQuadrantValues
     * @covers \App\SudokuSolver::__invoke
     * @covers \App\SudokuSolver::solveRecursively
     *
     * @dataProvider dataProviderSudokuHappyPath
     */
    public function testHappyPath(array $map, array $expectedSolution): void
    {
        $solution = (new SudokuSolver())($map);

        static::assertSame($expectedSolution, $solution);
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
     * @covers \App\SudokuSolver::checkSchema
     * @covers \App\SudokuSolver::__invoke
     *
     * @dataProvider dataProviderSudokuThrowExceptionWithWrongSchema
     */
    public function testThrowExceptionWithWrongSchema(array $map): void
    {
        $this->expectException(WrongSchemaException::class);

        (new SudokuSolver())($map);
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
     * @covers \App\SudokuSolver::pickFirstEmptyCell
     * @covers \App\SudokuSolver::checkSchema
     * @covers \App\SudokuSolver::getCandidates
     * @covers \App\SudokuSolver::getColValues
     * @covers \App\SudokuSolver::getRowValues
     * @covers \App\SudokuSolver::getQuadrantValues
     * @covers \App\SudokuSolver::__invoke
     * @covers \App\SudokuSolver::solveRecursively
     *
     * @dataProvider dataProviderSudokuThrowExceptionWithWrongContents
     */
    public function testThrowExceptionWithWrongContents(array $map): void
    {
        $this->expectException(CannotBeSolvedException::class);

        (new SudokuSolver())($map);
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
}
