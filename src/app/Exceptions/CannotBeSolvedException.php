<?php

namespace App\Exceptions;

use Exception;

final class CannotBeSolvedException extends Exception
{
    public function __construct()
    {
        $this->message = 'Sudoku is not following the basic rules.';
    }
}
