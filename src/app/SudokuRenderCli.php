<?php

namespace App;

final class SudokuRenderCli extends AbstractSudokuRender
{
    public const STARTS_WITH = '┏━━━━━━━━━━━┳━━━━━━━━━━━┳━━━━━━━━━━━┓';
    public const ENDS_WITH = '┗━━━━━━━━━━━┻━━━━━━━━━━━┻━━━━━━━━━━━┛';
    private const REPLACEMENTS = [
        'CA' => "\033[1;32m",
        'CB' => "\033[1;36m",
        'R'  => "\033[0m",
    ];

    /**
     * @param array<int, array<int, int>> $map
     */
    public function render(array $map): string
    {
        $this->checkSchema($map);

        return strtr(self::getTemplate(), self::REPLACEMENTS + self::getValuesReplacements($map));
    }

    protected static function getTemplate(): string
    {
        return implode(PHP_EOL, self::TEMPLATE);
    }
}
