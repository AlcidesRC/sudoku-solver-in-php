<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\CannotBeSolved;
use App\Exceptions\WrongSchema;
use App\SudokuGenerator;
use App\SudokuRenderCli;
use App\SudokuSolver;

$renderer = new SudokuRenderCli();

try {
    $map = (new SudokuGenerator())();
    echo $renderer($map, 'Input');

    $solution = (new SudokuSolver())($map);
    echo $renderer($solution, 'Solution');
} catch (CannotBeSolved | WrongSchema $e) {
    echo 'Oops [ ' . $e->getMessage() . ' ]' . PHP_EOL;
}
