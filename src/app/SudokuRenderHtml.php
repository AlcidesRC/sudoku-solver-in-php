<?php

declare(strict_types=1);

namespace App;

final class SudokuRenderHtml extends SudokuRender
{
    private const REPLACEMENTS = [
        'CA' => '<span style="color: lightgreen">',
        'CB' => '<span style="color: cyan">',
        'R'  => '</span>',
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
        $template = nl2br(implode(PHP_EOL, self::TEMPLATE));

        return implode(PHP_EOL, [
            '<figure id="sudoku">',
            $template,
            '<figcaption>' . $title . '</figcaption>',
            '</figure>',
        ]);
    }
}
