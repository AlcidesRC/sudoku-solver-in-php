<?php

namespace UnitTests;

use App\Sudoku;
use App\SudokuGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class SudokuGeneratorTest extends TestCase
{
    /**
     * @covers \App\SudokuGenerator::__invoke
     * @covers \App\SudokuGenerator::initializeSudoku
     * @covers \App\SudokuGenerator::generateSudoku
     * @covers \App\Sudoku::pickRandomEmptyCell
     * @covers \App\Sudoku::getRandomCandidate
     * @covers \App\Sudoku::getCandidates
     * @covers \App\Sudoku::getColValues
     * @covers \App\Sudoku::getQuadrantValues
     * @covers \App\Sudoku::getRowValues
     */
    public function testHappyPath(): void
    {
        $validContents = [...Sudoku::VALID_CANDIDATES, Sudoku::EMPTY_CELL_VALUE];

        $map = (new SudokuGenerator())();

        static::assertIsArray($map);
        static::assertSame(Sudoku::AXIS_TOTAL_CELLS, count($map));

        foreach ($map as $y => $row) {
            static::assertSame(Sudoku::AXIS_TOTAL_CELLS, count($row));

            foreach ($row as $x => $value) {
                static::assertIsNumeric($value);
                static::assertContainsEquals($value, $validContents);
            }
        }
    }
}
