<?php declare(strict_types=1);

namespace Sudoku\View\Text;

use Sudoku\View\Abstract\Cell;

/**
 * Trieda TextCell
 *
 * @package Sudoku\View\Text
 * @author  Roman Piller
 */
final class TextCell extends Cell
{
    /** @inheritDoc */
    public function write(): string
    {
        return ' ' . $this->content . ' ';
    }
}
