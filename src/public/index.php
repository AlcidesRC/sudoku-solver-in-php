<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\CannotBeSolvedException;
use App\Exceptions\WrongSchemaException;
use App\SudokuGenerator;
use App\SudokuRenderHtml;
use App\SudokuSolver;

$renderer = new SudokuRenderHtml();

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Sudoku</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <link rel='stylesheet' href='//cdn.jsdelivr.net/npm/hack-font@3.3.0/build/web/hack-subset.css'>

    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: black;
            color: lightgray;
        }

        figure#sudoku {
            display: inline-block;
            font-size: large;
            font-family: Hack, monospace;
        }
    </style>
</head>
<body>

<?php

try {
    $map = (new SudokuGenerator())();
    echo $renderer($map, 'Input');

    $solution = (new SudokuSolver())($map);
    echo $renderer($solution, 'Solution');
} catch (CannotBeSolvedException | WrongSchemaException $e) {
    echo 'Oops [ ' . $e->getMessage() . ' ]';
}

?>

</body>
</html>
