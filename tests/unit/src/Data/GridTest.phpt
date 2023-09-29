<?php declare(strict_types=1);

namespace Sudoku\Tests\Data;

require_once __DIR__ . '/../../bootstrap.php';

use Sudoku\Data\Grid;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see Grid}.
 *
 * @package Sudoku\Tests\Data
 * @author  Roman Piller
 * @testCase
 */
final class GridTest extends TestCase
{
  /** @var Grid Testovana trieda */
    private Grid $grid;

  /** @inheritDoc */
    protected function setUp(): void
    {
        parent::setUp();
        $this->grid = new Grid();
    }

  /**
   * Test pociatocneho stavu mriezky (vsetko nuly).
   *
   * @return void
   */
    public function testInitialState(): void
    {
        for ($row = 0; $row < Grid::ROWS; $row++) {
            for ($column = 0; $column < Grid::COLUMNS; $column++) {
                Assert::same(0, $this->grid->getCell($row, $column), "Bunka na pozicii [$row, $column] by mala byt 0.");
            }
        }
    }

  /**
   * Test zapisu a citania z bunky.
   *
   * @return void
   */
    public function testSetGetCell(): void
    {
        $this->grid->setCell(3, 4, 1);
        Assert::same(1, $this->grid->getCell(3, 4), 'Problem s nastavenim alebo ziskanim hodnoty bunky.');

        $this->grid->setCell(8, 8, 9);
        Assert::same(9, $this->grid->getCell(8, 8), 'Problem s nastavenim alebo ziskanim hodnoty bunky na okraji.');
    }

  /**
   * Test konstant mriezky.
   *
   * @return void
   */
    public function testConstants(): void
    {
        Assert::same(9, Grid::ROWS);
        Assert::same(9, Grid::COLUMNS);
    }
}

(new GridTest())->run();
