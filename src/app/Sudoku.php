<?php

namespace App;

use App\Exceptions\CannotBeSolvedException;

final class Sudoku extends AbstractSudoku
{
    private const QUADRANTS_PER_ROW = 3;
    private const QUADRANTS_RANGES = [
        0 => [0, 2],
        1 => [3, 5],
        2 => [6, 8],
    ];

    /** @var array<int, array<int, int>> */
    private array $map;

    /**
     * @param array<int, array<int, int>> $map
     *
     * @return array<int, array<int, int>>
     */
    public function solve(array $map): array
    {
        $this->checkSchema($map);

        $this->map = $map;

        if (!$this->solveRecursively()) {
            throw new CannotBeSolvedException();
        }

        return $this->map;
    }

    private function solveRecursively(): bool
    {
        [$y, $x] = $this->findEmptyCell();

        if (is_null($y) || is_null($x)) {
            return true;
        }

        foreach ($this->getCandidates($y, $x) as $candidate) {
            $this->map[$y][$x] = $candidate;

            if ($this->solveRecursively()) {
                return true;
            }

            $this->map[$y][$x] = 0;
        }

        return false;
    }

    /**
     * @return array<int>
     */
    private function getCandidates(int $y, int $x): array
    {
        $usedInRow = function (int $y): array {
            return $this->map[$y];
        };

        $usedInCol = function (int $x): array {
            $values = [];
            foreach ($this->map as $row) {
                $values[] = $row[$x];
            }

            return $values;
        };

        $getQuadrantLimits = function (int $index): array {
            $current = floor($index / self::QUADRANTS_PER_ROW);
            return self::QUADRANTS_RANGES[$current];
        };

        $usedInQuadrant = function (int $y, int $x) use ($getQuadrantLimits): array {
            [$iniY, $endY] = $getQuadrantLimits($y);
            [$iniX, $endX] = $getQuadrantLimits($x);

            $values = [];
            foreach (range($iniY, $endY) as $y) {
                foreach (range($iniX, $endX) as $x) {
                    $values[] = $this->map[$y][$x];
                }
            }

            return $values;
        };

        $used = array_merge($usedInCol($x), $usedInRow($y), $usedInQuadrant($y, $x));
        $used = array_filter($used);
        $used = array_unique($used, SORT_NUMERIC);

        return array_diff(self::VALUES_FOR_VALID_CANDIDATES, $used);
    }

    /**
     * @return array<null|int, null|int>
     */
    private function findEmptyCell(): array
    {
        foreach ($this->map as $y => $row) {
            $index = array_search(self::VALUE_FOR_EMPTY_CELL, $row, true);

            if (false !== $index) {
                return [$y, $index];
            }
        }

        return [null, null];
    }
}
