<?php declare(strict_types=1);

namespace Sudoku\Services;

use Sudoku\Data\Grid;
use Sudoku\Data\Services\GridService;
use Sudoku\Exceptions\FileNotFoundException;

/**
 * Servisna trieda pre pracu so Sudoku.
 *
 * @package Sudoku\Services
 * @author  Roman Piller
 */
final readonly class SudokuService
{
  /**
   * Konstruktor.
   *
   * @param GridService $gridService
   */
    public function __construct(private GridService $gridService)
    {
    }

  /**
   * Nahra zadanie sudoku zo suboru.
   *
   * @param string $filename
   * @param string $path
   * @return int[]
   * @throws FileNotFoundException
   */
    public function load(string $filename, string $path): array
    {
        $fullPath = rtrim($path, '/\\') . DIRECTORY_SEPARATOR . $filename;
        if (!file_exists($fullPath)) {
            throw new FileNotFoundException(
                sprintf('Subor %s nebol najdeny.', $fullPath)
            );
        }

        $content = (string)file_get_contents($fullPath);
        $cleanContent = str_replace(["\r", "\n", ' '], '', $content);
        $numbers = array_filter(explode(',', $cleanContent), static fn($val) => $val !== '');

        return array_map('intval', $numbers);
    }

  /**
   * Vyplni sudoku.
   *
   * @param Grid $grid
   * @return bool
   */
    public function analyze(Grid $grid): bool
    {
        for ($row = 0; $row < Grid::ROWS; $row++) {
            for ($column = 0; $column < Grid::COLUMNS; $column++) {
                // Hlada prazdne policko
                if ($grid->getCell($row, $column) === 0) {
                  //
                    for ($number = 1; $number <= Grid::ROWS; $number++) {
                        if ($this->gridService->checkPosition($grid, $row, $column, $number)) {
                            $grid->setCell($row, $column, $number);

                        // Rekurzivne riesi dalsiu bunku
                            if ($this->analyze($grid)) {
                                  return true;
                            }

                        // Analyza zlyhala - vycisti poziciu
                            $grid->setCell($row, $column, 0);
                        }
                    }
                  // Ziadne cislo nevyhovuje - zly vektor
                    return false;
                }
            }
        }
      // Formular bol uspesne vyplneny
        return true;
    }
}
