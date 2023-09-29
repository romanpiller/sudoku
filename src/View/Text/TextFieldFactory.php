<?php declare(strict_types=1);

namespace Sudoku\View\Text;

use Sudoku\Data\Grid;
use Sudoku\View\Abstract\Cell;
use Sudoku\View\Abstract\Field;
use Sudoku\View\Abstract\Row;
use Sudoku\View\FieldFactory;

/**
 * Trieda TextFieldFactory
 *
 * @package Sudoku\View\Text
 * @author  Roman Piller
 */
final class TextFieldFactory implements FieldFactory
{
    /** @inheritDoc */
    public function createCell(string $content): Cell
    {
        return new TextCell($content);
    }

    /** @inheritDoc */
    public function createRow(int $line = 1): Row
    {
        return new TextRow();
    }

    /** @inheritDoc */
    public function createField(): Field
    {
        return new TextField();
    }

    /** @inheritDoc */
    public function display(Grid $grid): string
    {
        $field = $this->createField();
        $rowGrid = $this->createRow();

        for ($row = 0; $row < Grid::ROWS; $row++) {
            for ($column = 0; $column < Grid::COLUMNS; $column++) {
                $number = $grid->getCell($row, $column);
                $cell = ($number === 0) ?
                $this->createCell(' ') :
                $this->createCell((string)$number);
                $rowGrid->addCell($cell);
            }
            $field->addRow($rowGrid);
            $rowGrid = $this->createRow();
        }

        return $field->write();
    }
}
