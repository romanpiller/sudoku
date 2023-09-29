<?php declare(strict_types=1);

namespace Sudoku\View\Html;

use Sudoku\View\Abstract\Cell;

/**
 * Trieda HtmlCell
 *
 * @package Sudoku\View\Html
 * @author  Roman Piller
 */
final class HtmlCell extends Cell
{
    /** @inheritDoc */
    public function write(): string
    {
        return $this->content;
    }
}
