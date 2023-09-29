<?php declare(strict_types=1);

namespace Sudoku\Tests\View;

require_once __DIR__ . '/../../bootstrap.php';

use Sudoku\Data\Grid;
use Sudoku\View\Html\HtmlFieldFactory;
use Sudoku\View\Text\TextFieldFactory;
use Sudoku\View\ViewService;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see ViewService}.
 *
 * @package Sudoku\Tests\View
 * @author  Roman Piller
 * @testCase
 */
final class ViewServiceTest extends TestCase
{
    /** @var ViewService Testovana sluzba */
    private ViewService $viewService;

    /** @inheritDoc */
    protected function setUp(): void
    {
        parent::setUp();
        $this->viewService = new ViewService(
            new TextFieldFactory(),
            new HtmlFieldFactory()
        );
    }

    /**
     * Test formatovania do textu.
     *
     * @return void
     */
    public function testFormatAsText(): void
    {
        $grid = new Grid();
        $grid->setCell(0, 0, 5);
        
        $output = $this->viewService->formatAsText($grid);
        
        Assert::contains('5', $output);
        Assert::type('string', $output);
    }

    /**
     * Test formatovania do HTML.
     *
     * @return void
     */
    public function testFormatAsHtml(): void
    {
        $grid = new Grid();
        $grid->setCell(0, 0, 5);
        
        $output = $this->viewService->formatAsHtml($grid);
        
        Assert::contains('<table', $output);
        Assert::contains('5', $output);
        Assert::type('string', $output);
    }

    /**
     * Test ulozenia do HTML suboru.
     *
     * @return void
     */
    public function testSaveAsHtml(): void
    {
        $grid = new Grid();
        $tempFile = tempnam(sys_get_temp_dir(), 'sudoku_test');
        
        $this->viewService->saveAsHtml($grid, $tempFile);
        
        Assert::true(file_exists($tempFile));
        Assert::contains('<table', (string) file_get_contents($tempFile));
        
        unlink($tempFile);
    }
}

(new ViewServiceTest())->run();
