<?php declare(strict_types=1);

namespace Sudoku\Tests\Facades;

require_once __DIR__ . '/../../bootstrap.php';

use Sudoku\Data\Services\GridService;
use Sudoku\Exceptions\InvalidArgumentException;
use Sudoku\Facades\SudokuFacade;
use Sudoku\Services\SudokuService;
use Sudoku\View\Html\HtmlFieldFactory;
use Sudoku\View\Text\TextFieldFactory;
use Sudoku\View\ViewService;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see SudokuFacade}.
 *
 * @package Sudoku\Tests\Facades
 * @author  Roman Piller
 * @testCase
 */
final class SudokuFacadeTest extends TestCase
{
    /** @var SudokuFacade Testovana fasada */
    private SudokuFacade $facade;

    /** @inheritDoc */
    protected function setUp(): void
    {
        parent::setUp();
        $gridService = new GridService();
        $sudokuService = new SudokuService($gridService);
        $viewService = new ViewService(new TextFieldFactory(), new HtmlFieldFactory());
        
        $this->facade = new SudokuFacade($sudokuService, $gridService, $viewService);
    }

    /**
     * Test vyriesenia sudoku cez fasadu.
     *
     * @return void
     */
    public function testSolve(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example.txt';
        
        $result = $this->facade->solve($filename, $path);
        
        Assert::true($result, 'Fasada by mala uspesne vyriesit sudoku.');
    }

    /**
     * Test vyriesenia a ulozenia do HTML.
     *
     * @return void
     */
    public function testSolveAndSave(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example.txt';
        $saveFile = 'result_test.html';
        $savePath = sys_get_temp_dir();
        
        $result = $this->facade->solve($filename, $path, false, $saveFile, $savePath);
        
        Assert::true($result);
        $fullSavePath = $savePath . DIRECTORY_SEPARATOR . $saveFile;
        Assert::true(file_exists($fullSavePath), 'Subor s riesenim by mal existovat.');
        
        // Upratovanie
        if (file_exists($fullSavePath)) {
            unlink($fullSavePath);
        }
    }

    /**
     * Test chyby pri nespravnych parametroch ukladania.
     *
     * @return void
     */
    public function testSolveInvalidParams(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example.txt';

        Assert::exception(function () use ($path, $filename) {
            $this->facade->solve($filename, $path, false, 'only_file.html', null);
        }, InvalidArgumentException::class);
    }

    /**
     * Test vypisu do konzoly.
     *
     * @return void
     */
    public function testSolveWithStdOut(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example.txt';

        ob_start();
        $result = $this->facade->solve($filename, $path, true);
        $output = (string) ob_get_clean();

        Assert::true($result);
        Assert::contains('1', $output); // Overime ze aspon nejake cislo tam je
    }

    /**
     * Test neriesitelneho sudoku.
     *
     * @return void
     */
    public function testSolveUnsolvable(): void
    {
        $tempPath = sys_get_temp_dir();
        $tempFile = 'unsolvable.txt';
        $numbers = array_fill(0, 81, 0);
        $numbers[1] = 1;
        $numbers[2] = 2;
        $numbers[3] = 3; // Riadok 0
        $numbers[9] = 4;
        $numbers[18] = 5;
        $numbers[27] = 6; // Stlpec 0
        $numbers[10] = 7;
        $numbers[11] = 8;
        $numbers[19] = 9; // Blok 0
        $content = implode(',', $numbers);
        file_put_contents($tempPath . DIRECTORY_SEPARATOR . $tempFile, $content);

        $result = $this->facade->solve($tempFile, $tempPath);

        Assert::false($result, 'Fasada by mala vratit false pre neriesitelne sudoku.');

        unlink($tempPath . DIRECTORY_SEPARATOR . $tempFile);
    }

    /**
     * Test nenajdeneho suboru.
     *
     * @return void
     */
    public function testSolveFileNotFound(): void
    {
        Assert::exception(function () {
            $this->facade->solve('non_existent.txt', '/non/existent/path');
        }, InvalidArgumentException::class);
    }
}

(new SudokuFacadeTest())->run();
