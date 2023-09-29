<?php declare(strict_types=1);

namespace Sudoku\Tests\Services;

require_once __DIR__ . '/../../bootstrap.php';

use Sudoku\Data\Services\GridService;
use Sudoku\Services\SudokuService;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see SudokuService}.
 *
 * @package Sudoku\Tests\Services
 * @author  Roman Piller
 * @testCase
 */
final class SudokuServiceTest extends TestCase
{
    /** @var SudokuService Testovana sluzba */
    private SudokuService $sudokuService;

    /** @var GridService Zavislost pre mriezku */
    private GridService $gridService;

    /** @inheritDoc */
    protected function setUp(): void
    {
        parent::setUp();
        $this->gridService = new GridService();
        $this->sudokuService = new SudokuService($this->gridService);
    }

    /**
     * Test nacitania dat zo suboru.
     *
     * @return void
     */
    public function testLoad(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example.txt';

        $numbers = $this->sudokuService->load($filename, $path);

        Assert::count(81, $numbers);
        Assert::same(6, $numbers[2]); // Prvy riadok, tretia hodnota
        Assert::same(0, $numbers[80]); // Posledna hodnota
    }

    /**
     * Test riesenia sudoku (analyze).
     *
     * @return void
     */
    public function testAnalyze(): void
    {
        // Velmi jednoduche sudoku (iba par chybajucich cisiel)
        // Vyplnime skoro celu mriezku platnymi cislami
        for ($r = 0; $r < 9; $r++) {
            for ($c = 0; $c < 9; $c++) {
                // Toto nie je uplne korektne sudoku ale pre test analyze(grid) staci ze najde riesenie
                // Skusime radsej realnejsie zadanie
            }
        }

        // Pouzijeme cisla z example.txt pre realny test
        $path = __DIR__ . '/../examples';
        $numbers = $this->sudokuService->load('example.txt', $path);
        $grid = $this->gridService->create($numbers);

        $result = $this->sudokuService->analyze($grid);

        Assert::true($result, 'Sudoku by malo byt vyriesitelne.');
        
        // Skontrolujeme ci je mriezka plna
        for ($r = 0; $r < 9; $r++) {
            for ($c = 0; $c < 9; $c++) {
                Assert::notSame(0, $grid->getCell($r, $c), "Bunka [$r, $c] by nemala byt prazdna.");
            }
        }
    }

    /**
     * Test zlyhania pri neexistujucom subore.
     *
     * @return void
     */
    public function testLoadFileNotFound(): void
    {
        Assert::exception(function () {
            $this->sudokuService->load('non-existent.txt', __DIR__);
        }, \Sudoku\Exceptions\FileNotFoundException::class);
    }
}

(new SudokuServiceTest())->run();
