<?php

namespace UnitTests;

use App\AbstractSudoku;
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
     * @covers \App\AbstractSudoku::pickRandomEmptyCell
     * @covers \App\AbstractSudoku::getRandomCandidate
     * @covers \App\AbstractSudoku::getCandidates
     * @covers \App\AbstractSudoku::getColValues
     * @covers \App\AbstractSudoku::getQuadrantValues
     * @covers \App\AbstractSudoku::getRowValues
     */
    public function testHappyPath(): void
    {
        $validContents = [...AbstractSudoku::VALID_CANDIDATES, AbstractSudoku::EMPTY_CELL_VALUE];

        $map = (new SudokuGenerator())();

        static::assertIsArray($map);
        static::assertSame(AbstractSudoku::AXIS_TOTAL_CELLS, count($map));

        foreach ($map as $y => $row) {
            static::assertSame(AbstractSudoku::AXIS_TOTAL_CELLS, count($row));

            foreach ($row as $x => $value) {
                static::assertIsNumeric($value);
                static::assertContainsEquals($value, $validContents);
            }
        }
    }
}
