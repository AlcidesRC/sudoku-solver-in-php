<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;
use App\Sudoku;
use App\SudokuRenderHtml;

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
    $output = (new SudokuRenderHtml())->render($solution);
} catch (CannotBeSolvedException | WrongSchemaException $e) {
    $output = 'Oops [ ' . $e->getMessage() . ' ]';
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Sudoku</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: black;
            color: lightgray;
        }

        div#sudoku {
            display: inline-block;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php echo $output ?>

</body>
</html>
