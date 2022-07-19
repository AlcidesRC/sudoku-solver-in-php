<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\CannotBeSolved;

final class SudokuSolver extends Sudoku
{
    /**
     * @param array<int, array<int, int|string>> $map
     *
     * @return array<int, array<int, int|string>>
     */
    public function __invoke(array $map): array
    {
        $this->checkSchema($map);

        $this->map = $map;

        if ( ! $this->solveRecursively()) {
            throw new CannotBeSolved();
        }

        return $this->map;
    }

    private function solveRecursively(): bool
    {
        [$y, $x] = $this->pickFirstEmptyCell();

        $isValidCell = ! is_null($y) && ! is_null($x);

        if ($isValidCell) {
            foreach ($this->getCandidates($y, $x) as $candidate) {
                $this->map[$y][$x] = $candidate;

                if ($this->solveRecursively()) {
                    return true;
                }

                $this->map[$y][$x] = self::EMPTY_CELL_VALUE;
            }

            return false;
        }

        return true;
    }
}
