<?php

namespace App;

abstract class AbstractSudokuRender extends AbstractSudoku
{
    protected const TEMPLATE = [
        '┏━━━━━━━━━━━┳━━━━━━━━━━━┳━━━━━━━━━━━┓',
        '┃ CA0:0R │ CA0:1R │ CA0:2R ┃ CB0:3R │ CB0:4R │ CB0:5R ┃ CA0:6R │ CA0:7R │ CA0:8R ┃',
        '┃───┼───┼───┃───┼───┼───┃───┼───┼───┃',
        '┃ CA1:0R │ CA1:1R │ CA1:2R ┃ CB1:3R │ CB1:4R │ CB1:5R ┃ CA1:6R │ CA1:7R │ CA1:8R ┃',
        '┃───┼───┼───┃───┼───┼───┃───┼───┼───┃',
        '┃ CA2:0R │ CA2:1R │ CA2:2R ┃ CB2:3R │ CB2:4R │ CB2:5R ┃ CA2:6R │ CA2:7R │ CA2:8R ┃',
        '┣━━━━━━━━━━━╋━━━━━━━━━━━╋━━━━━━━━━━━┫',
        '┃ CB3:0R │ CB3:1R │ CB3:2R ┃ CA3:3R │ CA3:4R │ CA3:5R ┃ CB3:6R │ CB3:7R │ CB3:8R ┃',
        '┃───┼───┼───┃───┼───┼───┃───┼───┼───┃',
        '┃ CB4:0R │ CB4:1R │ CB4:2R ┃ CA4:3R │ CA4:4R │ CA4:5R ┃ CB4:6R │ CB4:7R │ CB4:8R ┃',
        '┃───┼───┼───┃───┼───┼───┃───┼───┼───┃',
        '┃ CB5:0R │ CB5:1R │ CB5:2R ┃ CA5:3R │ CA5:4R │ CA5:5R ┃ CB5:6R │ CB5:7R │ CB5:8R ┃',
        '┣━━━━━━━━━━━╋━━━━━━━━━━━╋━━━━━━━━━━━┫',
        '┃ CA6:0R │ CA6:1R │ CA6:2R ┃ CB6:3R │ CB6:4R │ CB6:5R ┃ CA6:6R │ CA6:7R │ CA6:8R ┃',
        '┃───┼───┼───┃───┼───┼───┃───┼───┼───┃',
        '┃ CA7:0R │ CA7:1R │ CA7:2R ┃ CB7:3R │ CB7:4R │ CB7:5R ┃ CA7:6R │ CA7:7R │ CA7:8R ┃',
        '┃───┼───┼───┃───┼───┼───┃───┼───┼───┃',
        '┃ CA8:0R │ CA8:1R │ CA8:2R ┃ CB8:3R │ CB8:4R │ CB8:5R ┃ CA8:6R │ CA8:7R │ CA8:8R ┃',
        '┗━━━━━━━━━━━┻━━━━━━━━━━━┻━━━━━━━━━━━┛',
    ];

    /**
     * @param array<int, array<int, int>> $map
     */
    abstract public function render(array $map): string;

    abstract protected static function getTemplate(): string;

    /**
     * @param array<int, array<int, int>> $map
     *
     * @return array<string, string>
     */
    protected static function getValuesReplacements(array $map): array
    {
        $replacements = [];

        foreach ($map as $y => $row) {
            foreach ($row as $x => $value) {
                $replacements["{$y}:{$x}"] = (string) $value;
            }
        }

        return $replacements;
    }
}
