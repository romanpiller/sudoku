<?php declare(strict_types=1);

namespace Sudoku\View\Text;

use Sudoku\View\Abstract\Row;

/**
 * Trieda TextRow
 *
 * @package Sudoku\View\Text
 * @author  Roman Piller
 */
final class TextRow extends Row
{
    /** @inheritDoc */
    public function write(): string
    {
        $count = 1;
        $row = '|';
        foreach ($this->cells as $cell) {
            $row .= ($count++ % 3) ? $cell->write() : $cell->write() . '|';
        }
        return $row;
    }
}
