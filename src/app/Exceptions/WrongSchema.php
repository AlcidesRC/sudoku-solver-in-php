<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class WrongSchema extends Exception
{
    public function __construct()
    {
        $this->message = 'Sudoku grid consists of 9x9 spaces.';
    }
}
