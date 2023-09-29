<?php declare(strict_types=1);

namespace Sudoku\View\Html;

use Sudoku\Data\Grid;
use Sudoku\View\Abstract\Cell;
use Sudoku\View\Abstract\Field;
use Sudoku\View\Abstract\Row;
use Sudoku\View\FieldFactory;

/**
 * Trieda HtmlFieldFactory
 *
 * @package Sudoku\View\Html
 * @author  Roman Piller
 */
final class HtmlFieldFactory implements FieldFactory
{
  /** @inheritDoc */
    public function createCell(string $content): Cell
    {
        return new HtmlCell($content);
    }

  /** @inheritDoc */
    public function createRow(int $line = 1): Row
    {
        return new HtmlRow($line);
    }

  /** @inheritDoc */
    public function createField(): Field
    {
        return new HtmlField();
    }

  /** @inheritDoc */
    public function display(Grid $grid): string
    {
        $field = $this->createField();
        $rowGrid = $this->createRow(1);

        for ($row = 0; $row < Grid::ROWS; $row++) {
            for ($column = 0; $column < Grid::COLUMNS; $column++) {
                $number = $grid->getCell($row, $column);
                $cell = ($number === 0) ?
                $this->createCell('&nbsp;') :
                $this->createCell((string)$number);
                $rowGrid->addCell($cell);
            }
            $field->addRow($rowGrid);
            $rowGrid = $this->createRow(Row::COLUMNS * ($row + 1) + 1);
        }
        return
        '<!DOCTYPE html><html lang="en"><head><title>Sudoku</title><style>' .
        '.sudoku {margin: 5px auto;border-width: 3px;border-collapse: collapse;' .
        'border-color: #111;border-style: solid;text-align: center;background-color: #fff;}' .
        'td {text-align: center;border-width: 1px;border-color: black;' .
        'border-style:solid;height: 50px;width: 50px;font-size: 25px;background-color: transparent;' .
        'font-family: verdana,MS Sans Serif,times new roman;}' .

        '#c3, #c6, #c12, #c15, #c21, #c24, ' .
        '#c30, #c33, #c39, #c42, #c48, #c51, ' .
        '#c57, #c60, #c66, #c69, #c75, #c78 ' .
        '{border-right-width: 3px;}' .

        '#c28, #c29, #c30, #c31, #c32, #c33, #c34, #c35, #c36, ' .
        '#c55, #c56, #c57, #c58, #c59, #c60, #c61, #c62, #c63 ' .
        '{border-top-width: 3px;}' .

        '#c1, #c2, #c3, #c7, #c8, #c9, ' .
        '#c10, #c11, #c12, #c16, #c17, #c18, ' .
        '#c19, #c20, #c21, #c25, #c26, #c27, ' .
        '#c31, #c32, #c33, #c40, #c41, #c42, ' .
        '#c49, #c50, #c51, ' .
        '#c55, #c56, #c57, #c61, #c62, #c63, ' .
        '#c64, #c65, #c66, #c70, #c71, #c72, ' .
        '#c73, #c74, #c75, #c79, #c80, #c81 ' .
        '{background-color: #cccccc;}' .
        '</style></head><body>' .
        $field->write() .
        '</body></html>';
    }
}
