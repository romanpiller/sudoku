<?php declare(strict_types=1);

namespace Sudoku\Tests\Facades;

$container = require __DIR__ . '/../../bootstrap.php';

use Nette\DI\Container;
use Sudoku\Exceptions\InvalidArgumentException;
use Sudoku\Facades\SudokuFacade;
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

    /**
     * Konstruktor.
     *
     * @param Container $container
     */
    public function __construct(private readonly Container $container)
    {
    }

    /** @inheritDoc */
    protected function setUp(): void
    {
        parent::setUp();
        $this->facade = $this->container->getByType(SudokuFacade::class);
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
        $savePath = $path;
        
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
        Assert::contains('+-', $output); // Overime ze tam je aspon ramcek mriezky
        Assert::contains('1', $output); // Overime ze aspon nejake cislo tam je
    }

    /**
     * Test vyriesenia tazkeho sudoku.
     *
     * @return void
     */
    public function testSolveHard(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example-hard.txt';

        $result = $this->facade->solve($filename, $path);

        Assert::true($result, 'Fasada by mala uspesne vyriesit aj tazke sudoku.');
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

    /**
     * Test nevalidnych parametrov pre ulozenie.
     *
     * @return void
     */
    public function testSolveInvalidSaveParameters(): void
    {
        $path = __DIR__ . '/../examples';
        $filename = 'example.txt';

        // Len subor bez cesty
        $expectedMessage = 'Oba parametre (nazov suboru aj cesta) musia byt bud vyplnene alebo prazdne.';
        Assert::exception(function () use ($filename, $path) {
            $this->facade->solve($filename, $path, false, 'result.html', null);
        }, InvalidArgumentException::class, $expectedMessage);

        // Len cesta bez suboru
        Assert::exception(function () use ($filename, $path) {
            $this->facade->solve($filename, $path, false, null, $path);
        }, InvalidArgumentException::class, $expectedMessage);
    }
}

(new SudokuFacadeTest($container))->run();
