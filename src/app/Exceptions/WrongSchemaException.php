<?php

namespace App\Exceptions;

use Exception;

final class WrongSchemaException extends Exception
{
    public function __construct()
    {
        $this->message = 'Sudoku grid consists of 9x9 spaces.';
    }
}
