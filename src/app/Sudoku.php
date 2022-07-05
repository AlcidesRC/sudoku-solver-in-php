<?php

namespace App;

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;

final class Sudoku
{
    public const SIZE = 9;
    private const CLI__COLOR_A = "\033[1;32m";
    private const CLI__COLOR_B = "\033[1;36m";
    private const CLI__RESET = "\033[0m";
    private const CLI__TEMPLATE = '┏━━━━━━━━━━━┳━━━━━━━━━━━┳━━━━━━━━━━━┓
┃ CA0:0R │ CA0:1R │ CA0:2R ┃ CB0:3R │ CB0:4R │ CB0:5R ┃ CA0:6R │ CA0:7R │ CA0:8R ┃
┃───┼───┼───┃───┼───┼───┃───┼───┼───┃
┃ CA1:0R │ CA1:1R │ CA1:2R ┃ CB1:3R │ CB1:4R │ CB1:5R ┃ CA1:6R │ CA1:7R │ CA1:8R ┃
┃───┼───┼───┃───┼───┼───┃───┼───┼───┃
┃ CA2:0R │ CA2:1R │ CA2:2R ┃ CB2:3R │ CB2:4R │ CB2:5R ┃ CA2:6R │ CA2:7R │ CA2:8R ┃
┣━━━━━━━━━━━╋━━━━━━━━━━━╋━━━━━━━━━━━┫
┃ CB3:0R │ CB3:1R │ CB3:2R ┃ CA3:3R │ CA3:4R │ CA3:5R ┃ CB3:6R │ CB3:7R │ CB3:8R ┃
┃───┼───┼───┃───┼───┼───┃───┼───┼───┃
┃ CB4:0R │ CB4:1R │ CB4:2R ┃ CA4:3R │ CA4:4R │ CA4:5R ┃ CB4:6R │ CB4:7R │ CB4:8R ┃
┃───┼───┼───┃───┼───┼───┃───┼───┼───┃
┃ CB5:0R │ CB5:1R │ CB5:2R ┃ CA5:3R │ CA5:4R │ CA5:5R ┃ CB5:6R │ CB5:7R │ CB5:8R ┃
┣━━━━━━━━━━━╋━━━━━━━━━━━╋━━━━━━━━━━━┫
┃ CA6:0R │ CA6:1R │ CA6:2R ┃ CB6:3R │ CB6:4R │ CB6:5R ┃ CA6:6R │ CA6:7R │ CA6:8R ┃
┃───┼───┼───┃───┼───┼───┃───┼───┼───┃
┃ CA7:0R │ CA7:1R │ CA7:2R ┃ CB7:3R │ CB7:4R │ CB7:5R ┃ CA7:6R │ CA7:7R │ CA7:8R ┃
┃───┼───┼───┃───┼───┼───┃───┼───┼───┃
┃ CA8:0R │ CA8:1R │ CA8:2R ┃ CB8:3R │ CB8:4R │ CB8:5R ┃ CA8:6R │ CA8:7R │ CA8:8R ┃
┗━━━━━━━━━━━┻━━━━━━━━━━━┻━━━━━━━━━━━┛
';
    private const HTML__COLOR_A = '<span style="color: lightgreen">';
    private const HTML__COLOR_B = '<span style="color: cyan">';
    private const HTML__RESET = '</span>';
    private const HTML__TEMPLATE = '<div id="sudoku" style="font-family:monospace;">' . self::CLI__TEMPLATE . '</div>';

    /** @var array<int, array<int, int>> */
    public array $map;

    /**
     * @param array<int, array<int, int>> $map
     */
    public function solve(array $map): self
    {
        if (!$this->hasValidSchema($map)) {
            throw new WrongSchemaException();
        }

        $this->map = $map;

        if (!$this->solveRecursively()) {
            throw new CannotBeSolvedException();
        }

        return $this;
    }

    public function asCli(): string
    {
        $output = strtr(self::CLI__TEMPLATE, [
            'CA' => self::CLI__COLOR_A,
            'CB' => self::CLI__COLOR_B,
            'R'  => self::CLI__RESET,
        ]);

        return $this->fillTemplate($output);
    }

    public function asHtml(): string
    {
        $output = strtr(self::HTML__TEMPLATE, [
            'CA' => self::HTML__COLOR_A,
            'CB' => self::HTML__COLOR_B,
            'R'  => self::HTML__RESET,
        ]);

        $output = $this->fillTemplate($output);

        return nl2br($output);
    }

    /**
     * @param array<int, array<int, int>> $map
     */
    private function hasValidSchema(array $map): bool
    {
        if (self::SIZE !== \count($map)) {
            return false;
        }

        foreach (range(0, 8) as $y) {
            if (self::SIZE !== \count($map[$y])) {
                return false;
            }

            foreach (range(0, 8) as $x) {
                $value = $map[$y][$x];

                if (!\is_int($value)) {
                    return false;
                }

                if ($value < 0) {
                    return false;
                }

                if ($value > 9) {
                    return false;
                }
            }
        }

        return true;
    }

    private function solveRecursively(): bool
    {
        [$y, $x] = $this->findEmptyCell();

        if (null === $x || null === $y) {
            return true;
        }

        foreach (range(1, 9) as $candidate) {
            if ($this->isCandidateTaken($candidate, $y, $x)) {
                continue;
            }

            $this->map[$y][$x] = $candidate;

            if ($this->solveRecursively()) {
                return true;
            }

            $this->map[$y][$x] = 0;
        }

        return false;
    }

    /**
     * @return array<null|int, null|int>
     */
    private function findEmptyCell(): array
    {
        foreach (range(0, 8) as $y) {
            $index = array_search(0, $this->map[$y], true);

            if (false !== $index) {
                return [$y, $index];
            }
        }

        return [null, null];
    }

    private function isCandidateTaken(int $candidate, int $y, int $x): bool
    {
        $isSelected = function (int $candidate, array $values): bool {
            return false !== array_search($candidate, $values, true);
        };

        $isTakenInRow = function (int $candidate, int $y) use ($isSelected): bool {
            return $isSelected($candidate, $this->map[$y]);
        };

        $isTakenInCol = function (int $candidate, int $x) use ($isSelected): bool {
            return $isSelected($candidate, array_column($this->map, $x));
        };

        $getQuadrantLimits = function (int $index): array {
            return match ($index) {
                0, 1, 2 => [0, 2],
                3, 4, 5 => [3, 5],
                default => [6, 8],
            };
        };

        $isTakenInQuadrant = function (int $candidate, int $y, int $x) use ($getQuadrantLimits, $isSelected): bool {
            [$iniY, $endY] = $getQuadrantLimits($y);
            [$iniX, $endX] = $getQuadrantLimits($x);

            $values = [];
            for ($y = $iniY; $y <= $endY; ++$y) {
                for ($x = $iniX; $x <= $endX; ++$x) {
                    $values[] = $this->map[$y][$x];
                }
            }

            return $isSelected($candidate, $values);
        };

        return $isTakenInRow($candidate, $y)
               || $isTakenInCol($candidate, $x)
               || $isTakenInQuadrant($candidate, $y, $x);
    }

    private function fillTemplate(string $output): string
    {
        foreach (range(0, 8) as $y) {
            foreach (range(0, 8) as $x) {
                $output = str_replace("{$y}:{$x}", (string) $this->map[$y][$x], $output);
            }
        }

        return $output;
    }
}
