<?php declare(strict_types=1);

namespace Sudoku\Facades;

use Sudoku\Data\Services\GridService;
use Sudoku\Exceptions\FileNotFoundException;
use Sudoku\Exceptions\InvalidArgumentException;
use Sudoku\Services\SudokuService;
use Sudoku\View\ViewService;

/**
 * Fasada sudoku
 *
 * @package Sudoku\Facades
 * @author  Roman Piller
 */
final readonly class SudokuFacade
{
  /**
   * Konstruktor.
   *
   * @param SudokuService    $sudokuService
   * @param GridService      $gridService
   * @param ViewService      $viewService
   */
    public function __construct(
        private SudokuService $sudokuService,
        private GridService $gridService,
        private ViewService $viewService,
    ) {
    }

  /**
   * Vyriesi sudoku.
   *
   * @param string      $loadFile Nazov suboru so zadanim.
   * @param string      $loadPath Cesta k suboru zo zadanim
   * @param bool        $stdOut   Vypisovat zadanie a riesenie do konzoly.
   * @param string|null $saveFile Nazov suboru s riesenim.
   * @param string|null $savePath Cesta k suboru s ulozenym riesenim.
   * @return bool
   * @throws InvalidArgumentException Nevalidne vstupne parametre.
   */
    public function solve(
        string $loadFile,
        string $loadPath,
        bool $stdOut = false,
        ?string $saveFile = null,
        ?string $savePath = null
    ): bool {
        try {
            // Nacita zadanie
            $numbers = $this->sudokuService->load($loadFile, $loadPath);

            // Vytvori grid
            $grid = $this->gridService->create($numbers);

            if ($stdOut) {
                // Vypise zadanie.
                echo $this->viewService->formatAsText($grid) . PHP_EOL;
            }
            if (!$this->sudokuService->analyze($grid)) {
                return false;
            }

            if ($stdOut) {
              // Vypise riesenie.
                echo $this->viewService->formatAsText($grid) . PHP_EOL;
            }

            if (($saveFile === null) !== ($savePath === null)) {
                throw new InvalidArgumentException(
                    'Oba parametre (nazov suboru aj cesta) musia byt bud vyplnene alebo prazdne.'
                );
            }

            if ($saveFile !== null && $savePath !== null) {
                $this->viewService->saveAsHtml($grid, rtrim($savePath, '/\\') . DIRECTORY_SEPARATOR . $saveFile);
            }
        } catch (FileNotFoundException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
        return true;
    }
}
