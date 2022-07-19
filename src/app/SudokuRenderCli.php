<?php

declare(strict_types=1);

namespace App;

final class SudokuRenderCli extends SudokuRender
{
    private const REPLACEMENTS = [
        'CA' => "\033[1;32m",
        'CB' => "\033[1;36m",
        'R'  => "\033[0m",
    ];

    /**
     * @param array<int, array<int, int>> $map
     */
    public function __invoke(array $map, ?string $title = ''): string
    {
        $this->checkSchema($map);

        return strtr(self::getTemplate($title), self::REPLACEMENTS + self::getValuesReplacements($map));
    }

    protected static function getTemplate(?string $title = ''): string
    {
        return implode(PHP_EOL, [
            ...self::TEMPLATE,
            $title,
            '',
        ]);
    }
}
