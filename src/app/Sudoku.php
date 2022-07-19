<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\WrongSchema;

abstract class Sudoku
{
    public const EMPTY_CELL_VALUE = 0;
    public const EMPTY_CELL_VALUE_PLACEHOLDER = '_';
    public const TOTAL_CLUES = 17;
    public const TOTAL_QUADRANTS_PER_ROW = 3;
    public const AXIS_INDEX_MIN = 0;
    public const AXIS_INDEX_MAX = 8;
    public const AXIS_TOTAL_CELLS = 9;
    public const VALID_CANDIDATES = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    public const QUADRANTS_RANGES = [
        0 => [0, 2],
        1 => [3, 5],
        2 => [6, 8],
    ];

    /** @var array<int, array<int, int|string>> */
    protected array $map;

    /**
     * @return array<int|null, int|null>
     */
    protected function pickFirstEmptyCell(): array
    {
        foreach ($this->map as $y => $row) {
            $index = array_search(self::EMPTY_CELL_VALUE, $row, true);

            if ($index !== false) {
                return [$y, $index];
            }
        }

        return [null, null];
    }

    /**
     * @return array<int|null, int|null>
     */
    protected function pickRandomEmptyCell(): array
    {
        $emptyCells = [];
        foreach ($this->map as $y => $row) {
            foreach ($row as $x => $value) {
                if ($value === self::EMPTY_CELL_VALUE) {
                    $emptyCells[] = [$y, $x];
                }
            }
        }

        shuffle($emptyCells);

        return array_pop($emptyCells) ?? [null, null];
    }

    /**
     * @return array<int|string>
     */
    protected function getRowValues(int $y): array
    {
        return $this->map[$y];
    }

    /**
     * @return array<int|string>
     */
    protected function getColValues(int $x): array
    {
        return array_map(static function ($entry) use ($x) {
            return $entry[$x];
        }, $this->map);
    }

    /**
     * @return array<int|string>
     */
    protected function getQuadrantValues(int $y, int $x): array
    {
        $getQuadrantLimits = static function (int $index): array {
            $current = floor($index / self::TOTAL_QUADRANTS_PER_ROW);
            return self::QUADRANTS_RANGES[$current];
        };

        [$iniY, $endY] = $getQuadrantLimits($y);
        [$iniX, $endX] = $getQuadrantLimits($x);

        $values = [];
        foreach (range($iniY, $endY) as $y) {
            foreach (range($iniX, $endX) as $x) {
                $values[] = $this->map[$y][$x];
            }
        }

        return $values;
    }

    /**
     * @return array<int>
     */
    protected function getCandidates(int $y, int $x): array
    {
        $used = array_merge($this->getRowValues($y), $this->getColValues($x), $this->getQuadrantValues($y, $x));
        $used = array_diff($used, [self::EMPTY_CELL_VALUE]);
        $used = array_unique($used, SORT_NUMERIC);

        return array_values(array_diff(self::VALID_CANDIDATES, $used));
    }

    protected function getRandomCandidate(int $y, int $x): int
    {
        $candidates = $this->getCandidates($y, $x);

        shuffle($candidates);

        return array_pop($candidates) ?? self::EMPTY_CELL_VALUE;
    }

    /**
     * @param array<int, array<int, int|string>> $map
     */
    protected function checkSchema(array $map): void
    {
        $validContents = [...self::VALID_CANDIDATES, self::EMPTY_CELL_VALUE];

        if (\count($map) !== self::AXIS_TOTAL_CELLS) {
            throw new WrongSchema();
        }

        foreach ($map as $row) {
            if (\count($row) !== self::AXIS_TOTAL_CELLS) {
                throw new WrongSchema();
            }

            foreach ($row as $value) {
                if (array_search($value, $validContents, true) === false) {
                    throw new WrongSchema();
                }
            }
        }
    }
}
