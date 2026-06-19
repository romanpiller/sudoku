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
   * @param string           $loadPath      Adresar so zadaniami.
   * @param string           $savePath      Adresar kam sa ulozia riesenia.
   * @param bool             $stdOut        Vypise zadanie aj riesenie do konzoly.
   */
    public function __construct(
        private SudokuService $sudokuService,
        private GridService $gridService,
        private ViewService $viewService,
        private string $loadPath,
        private string $savePath,
        private bool $stdOut = false,
    ) {
    }

  /**
   * Vyriesi sudoku.
   *
   * @param string      $loadFile Nazov suboru so zadanim.
   * @param string|null $loadPath Cesta k suboru zo zadanim
   * @param bool|null   $stdOut   Vypisovat zadanie a riesenie do konzoly.
   * @param string|null $saveFile Nazov suboru s riesenim.
   * @param string|null $savePath Cesta k suboru s ulozenym riesenim.
   * @return bool
   * @throws InvalidArgumentException Nevalidne vstupne parametre.
   */
    public function solve(
        string $loadFile,
        ?string $loadPath = null,
        ?bool $stdOut = null,
        ?string $saveFile = null,
        ?string $savePath = null
    ): bool {
        // Ak hodnoty parametrov zo solve maju hodnotu null prepisu sa hodnotami instancnych atributov
        $loadPath ??= $this->loadPath;
        $stdOut ??= $this->stdOut;

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

            if ($saveFile !== null) {
                $savePath = $this->savePath;
                $this->viewService->saveAsHtml($grid, rtrim($savePath, '/\\') . DIRECTORY_SEPARATOR . $saveFile);
            }
        } catch (FileNotFoundException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
        return true;
    }
}
