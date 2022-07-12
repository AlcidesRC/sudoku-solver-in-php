<?php

namespace App;

final class SudokuGenerator extends AbstractSudoku
{
    /**
     * @return array<int, array<int, int|string>>
     */
    public function __invoke(): array
    {
        $this->initializeSudoku();

        $this->generateSudoku();

        return $this->map;
    }

    private function initializeSudoku(): void
    {
        $this->map = array_fill(self::AXIS_INDEX_MIN, self::AXIS_TOTAL_CELLS, []);

        foreach (range(self::AXIS_INDEX_MIN, self::AXIS_INDEX_MAX) as $y) {
            $this->map[$y] = array_fill(self::AXIS_INDEX_MIN, self::AXIS_TOTAL_CELLS, self::EMPTY_CELL_VALUE);
        }
    }

    private function generateSudoku(): void
    {
        foreach (range(1, self::TOTAL_CLUES) as $clue) {
            do {
                [$y, $x] = $this->pickRandomEmptyCell();

                $isValidCell = !is_null($y) && !is_null($x);
            } while (!$isValidCell);

            $this->map[$y][$x] = $this->getRandomCandidate($y, $x);
        }
    }
}
