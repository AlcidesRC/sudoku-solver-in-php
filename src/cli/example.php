<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;
use App\SudokuGenerator;
use App\SudokuRenderCli;
use App\SudokuSolver;

$renderer = new SudokuRenderCli();

try {
    $map = (new SudokuGenerator())();
    echo $renderer($map, 'Input');

    $solution = (new SudokuSolver())($map);
    echo $renderer($solution, 'Solution');
} catch (CannotBeSolvedException | WrongSchemaException $e) {
    echo 'Oops [ ' . $e->getMessage() . ' ]' . PHP_EOL;
}
