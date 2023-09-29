<?php declare(strict_types=1);

namespace Sudoku\View\Text;

use Sudoku\View\Abstract\Field;

/**
 * Trieda TextField
 *
 * @package Sudoku\View\Text
 * @author  Roman Piller
 */
final class TextField extends Field
{
    /** @inheritDoc */
    public function write(): string
    {
        $count = 1;
        $lines = '+---------+---------+---------+' . PHP_EOL;
        foreach ($this->rows as $row) {
            $lines .= ($count++ % 3)
                ? $row->write() . PHP_EOL
                : $row->write() . PHP_EOL . '+---------+---------+---------+' . PHP_EOL;
        }
        return rtrim($lines);
    }
}
