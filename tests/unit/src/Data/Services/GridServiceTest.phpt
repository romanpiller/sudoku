<?php declare(strict_types=1);

namespace Sudoku\Tests\Data\Services;

require_once __DIR__ . '/../../../bootstrap.php';

use Sudoku\Data\Grid;
use Sudoku\Data\Services\GridService;
use Sudoku\Exceptions\InvalidArgumentException;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see GridService}.
 *
 * @package Sudoku\Tests\Data\Services
 * @author  Roman Piller
 * @testCase
 */
final class GridServiceTest extends TestCase
{
   /** @var GridService Testovana trieda */
    private GridService $gridService;

    /** @inheritDoc */
    protected function setUp(): void
    {
        parent::setUp();
        $this->gridService = new GridService();
    }

  /**
   * Test vytvorenia mriezky z pola cisiel.
   *
   * @return void
   */
    public function testCreate(): void
    {
        $numbers = array_fill(0, 81, 0);
        $numbers[0] = 5;
        $numbers[80] = 9;

        $grid = $this->gridService->create($numbers);

        Assert::type(Grid::class, $grid);
        Assert::same(5, $grid->getCell(0, 0));
        Assert::same(9, $grid->getCell(8, 8));
    }

    /**
     * Test vyhodenia vynimky pri nespravnom pocte cisiel.
     *
     * @return void
     */
    public function testCreateInvalidCount(): void
    {
        Assert::exception(function () {
            $this->gridService->create([1, 2, 3]);
        }, InvalidArgumentException::class, 'Neplatny pocet (3) cisel v zadani.');
    }

    /**
     * Test kontroly pozicie (checkPosition).
     *
     * @return void
     */
    public function testCheckPosition(): void
    {
        $grid = new Grid();
        
        // Nastavime nejake cisla
        $grid->setCell(0, 0, 5);
        $grid->setCell(0, 1, 3);
        $grid->setCell(1, 0, 6);

        // Kontrola riadku (cislo 3 uz je v nultom riadku)
        Assert::false($this->gridService->checkPosition($grid, 0, 5, 3), 'Cislo 3 uz je v riadku.');

        // Kontrola stlpca (cislo 6 uz je v nultom stlpci)
        Assert::false($this->gridService->checkPosition($grid, 5, 0, 6), 'Cislo 6 uz je v stlpci.');

        // Kontrola stvorca (cislo 5 uz je v prvom stvorci 3x3)
        Assert::false($this->gridService->checkPosition($grid, 2, 2, 5), 'Cislo 5 uz je v stvorci.');

        // Kontrola platneho tahu
        Assert::true($this->gridService->checkPosition($grid, 0, 8, 1), 'Cislo 1 by malo byt mozne umiestnit.');
    }
}

(new GridServiceTest())->run();
