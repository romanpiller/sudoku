<?php declare(strict_types=1);

namespace Sudoku\Data;

/**
 * Mriezka
 *
 * @package Sudoku\Data
 * @author  Roman Piller
 */
final class Grid
{
  /** @var int Pocet riadkov. */
    public const ROWS = 9;

  /** @var int Pocet stlpcov. */
    public const COLUMNS = 9;

  /** @var int[][] Mriezka. */
    private array $grid;

  /**
   * Konstruktor inicializuje mriezku nulami.
   */
    public function __construct()
    {
        $this->grid = array_fill(0, self::ROWS, array_fill(0, self::COLUMNS, 0));
    }

  /**
   * Cita policko z mriezky.
   *
   * @param int $row
   * @param int $column
   * @return int
   */
    public function getCell(int $row, int $column): int
    {
        return $this->grid[$row][$column];
    }

  /**
   * Nastavi policko v mriezke.
   *
   * @param int $row
   * @param int $column
   * @param int $number
   * @return void
   */
    public function setCell(int $row, int $column, int $number): void
    {
        $this->grid[$row][$column] = $number;
    }
}
