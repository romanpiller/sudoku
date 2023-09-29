<?php declare(strict_types=1);

namespace Sudoku\Data\Services;

use Sudoku\Data\Grid;
use Sudoku\Exceptions\InvalidArgumentException;

/**
 * Servisna trieda na pracu s {@see Grid}.
 *
 * @package Sudoku\Data\Services
 * @author  Roman Piller
 */
final readonly class GridService
{
  /**
   * Vytvori pole zo sekvencie cisel.
   * Sekvencia cisel je zadanie ulozene po riadkoch za sebou.
   *
   * @param int[] $numbers
   * @return Grid
   * @throws InvalidArgumentException
   */
    public function create(array $numbers): Grid
    {
        if (count($numbers) !== Grid::ROWS * Grid::COLUMNS) {
            throw new InvalidArgumentException(
                sprintf(
                    'Neplatny pocet (%d) cisel v zadani.',
                    count($numbers)
                )
            );
        }

        $grid = new Grid();
        for ($row = 0; $row < Grid::ROWS; $row++) {
            for ($column = 0; $column < Grid::COLUMNS; $column++) {
                $grid->setCell($row, $column, $numbers[Grid::ROWS * $row + $column]);
            }
        }
        return $grid;
    }

  /**
   * Kontroluje ci cislo uz nie je pouzite v danom riadku, stlpci alebo stvorci.
   *
   * @param Grid $grid
   * @param int  $row
   * @param int  $column
   * @param int  $number
   * @return bool
   */
    public function checkPosition(Grid $grid, int $row, int $column, int $number): bool
    {
      // Kontrola voci riadku a stlpci
        for ($i = 0; $i < Grid::ROWS; $i++) {
            if ($grid->getCell($i, $column) === $number || $grid->getCell($row, $i) === $number) {
                return false;
            }
        }

      // Kontrola voci stvorcu
        $startRow = $row - $row % 3;
        $startColumn = $column - $column % 3;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($grid->getCell($startRow + $i, $startColumn + $j) === $number) {
                    return false;
                }
            }
        }
        return true;
    }
}
