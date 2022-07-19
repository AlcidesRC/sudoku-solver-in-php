<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CannotBeSolved extends Exception
{
    public function __construct()
    {
        $this->message = 'Sudoku is not following the basic rules.';
    }
}
