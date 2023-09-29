<?php declare(strict_types=1);

namespace Sudoku\View\Html;

use Sudoku\View\Abstract\Row;

/**
 * Trieda HtmlRow
 *
 * @package Sudoku\View\Html
 * @author  Roman Piller
 */
final class HtmlRow extends Row
{
    /**
     * Konstruktor
     *
     * @param int $count
     */
    public function __construct(private int $count)
    {
    }

    /** @inheritDoc */
    public function write(): string
    {
        $row = '<tr>';
        foreach ($this->cells as $cell) {
            $row .= '<td id="c' . $this->count++ . '">' . $cell->write() . '</td>';
        }
        return $row . '</tr>';
    }
}
