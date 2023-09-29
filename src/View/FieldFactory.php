<?php declare(strict_types=1);

namespace Sudoku\View;

use Sudoku\Data\Grid;
use Sudoku\View\Abstract\Cell;
use Sudoku\View\Abstract\Field;
use Sudoku\View\Abstract\Row;

/**
 * Rozhranie FieldFactory
 *
 * @package Sudoku\View
 * @author  Roman Piller
 */
interface FieldFactory
{
    /**
     * Vytvori bunku
     *
     * @param string $content
     * @return Cell
     */
    public function createCell(string $content): Cell;

    /**
     * Vytvori riadok
     *
     * @param  int $line
     * @return Row
     */
    public function createRow(int $line): Row;

    /**
     * Vytvori pole
     *
     * @return Field
     */
    public function createField(): Field;

    /**
     * Vrati pole ako retazec
     *
     * @param  Grid $grid
     * @return string
     */
    public function display(Grid $grid): string;
}
