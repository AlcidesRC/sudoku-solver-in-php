<?php

namespace App;

use App\Exceptions\WrongSchemaException;

abstract class AbstractSudoku
{
    protected const MAX_SIZE = 9;
    protected const VALUES_FOR_VALID_CANDIDATES = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    protected const VALUE_FOR_EMPTY_CELL = 0;

    /**
     * @param array<int, array<int, int>> $map
     */
    protected function checkSchema(array $map): void
    {
        if (self::MAX_SIZE !== \count($map)) {
            throw new WrongSchemaException();
        }

        foreach ($map as $y => $row) {
            if (self::MAX_SIZE !== \count($row)) {
                throw new WrongSchemaException();
            }

            foreach ($row as $x => $value) {
                if (!in_array($value, self::VALUES_FOR_VALID_CANDIDATES, true)) {
                    if ($value !== self::VALUE_FOR_EMPTY_CELL) {
                        throw new WrongSchemaException();
                    }
                }
            }
        }
    }
}
