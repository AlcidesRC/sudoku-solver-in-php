<?php

namespace App;

final class SudokuRenderHtml extends AbstractSudokuRender
{
    public const STARTS_WITH = '<div id="sudoku" style="font-family: monospace">';
    public const ENDS_WITH = '</div>';
    private const REPLACEMENTS = [
        'CA' => '<span style="color: lightgreen">',
        'CB' => '<span style="color: cyan">',
        'R'  => '</span>',
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
        $template = nl2br(implode(PHP_EOL, self::TEMPLATE));

        return implode(PHP_EOL, [
            self::STARTS_WITH,
            $template,
            self::ENDS_WITH,
        ]);
    }
}
