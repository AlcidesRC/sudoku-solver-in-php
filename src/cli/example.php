<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;
use App\Sudoku;
use App\SudokuRenderCli;

$map = [
    [8, 0, 0,    0, 0, 0,    0, 0, 0],
    [0, 0, 3,    6, 0, 0,    0, 0, 0],
    [0, 7, 0,    0, 9, 0,    2, 0, 0],

    [0, 5, 0,    0, 0, 7,    0, 0, 0],
    [0, 0, 0,    0, 4, 5,    7, 0, 0],
    [0, 0, 0,    1, 0, 0,    0, 3, 0],

    [0, 0, 1,    0, 0, 0,    0, 6, 8],
    [0, 0, 8,    5, 0, 0,    0, 1, 0],
    [0, 9, 0,    0, 0, 0,    4, 0, 0],
];

try {
    $solution = (new Sudoku())->solve($map);
    $output = (new SudokuRenderCli())->render($solution);
} catch (CannotBeSolvedException | WrongSchemaException $e) {
    echo 'Oops [ ' . $e->getMessage() . ' ]' . PHP_EOL;
}

echo $output;
