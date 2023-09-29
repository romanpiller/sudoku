<?php declare(strict_types=1);

namespace Sudoku\Tests\View\Abstract;

require_once __DIR__ . '/../../../bootstrap.php';

use Sudoku\View\Abstract\Cell;
use Sudoku\View\Abstract\Field;
use Sudoku\View\Abstract\Row;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test abstraktnych komponentov View.
 *
 * @package Sudoku\Tests\View\Abstract
 * @author  Roman Piller
 * @testCase
 */
final class ComponentTest extends TestCase
{
    /**
     * Test abstraktnej bunky (Cell).
     *
     * @return void
     */
    public function testCell(): void
    {
        $cell = new class ('5') extends Cell {
            public function write(): string
            {
                return "[$this->content]";
            }
        };
        
        Assert::same('[5]', $cell->write());
    }

    /**
     * Test abstraktneho riadku (Row).
     *
     * @return void
     */
    public function testRow(): void
    {
        $row = new class () extends Row {
            public function write(): string
            {
                $out = '';
                foreach ($this->cells as $cell) {
                    $out .= $cell->write();
                }
                return $out;
            }
        };
        
        $cell = new class ('1') extends Cell {
            public function write(): string
            {
                return $this->content;
            }
        };
        
        $row->addCell($cell);
        Assert::same('1', $row->write());
    }

    /**
     * Test abstraktneho pola (Field).
     *
     * @return void
     */
    public function testField(): void
    {
        $field = new class () extends Field {
            public function write(): string
            {
                $out = '';
                foreach ($this->rows as $row) {
                    $out .= $row->write();
                }
                return $out;
            }
        };
        
        $row = new class () extends Row {
            public function write(): string
            {
                return 'R';
            }
        };
        
        $field->addRow($row);
        Assert::same('R', $field->write());
    }
}

(new ComponentTest())->run();
