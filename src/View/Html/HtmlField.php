<?php declare(strict_types=1);

namespace Sudoku\View\Html;

use Sudoku\View\Abstract\Field;

/**
 * Trieda HtmlField
 *
 * @package Sudoku\View\Html
 * @author  Roman Piller
 */
final class HtmlField extends Field
{
    /** @inheritDoc */
    public function write(): string
    {
        $lines = '<table class="sudoku">';
        foreach ($this->rows as $row) {
            $lines .= $row->write();
        }
        return $lines . '</table>';
    }
}
