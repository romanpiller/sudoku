<?php declare(strict_types=1);

namespace Sudoku\Tests\View\Html;

require_once __DIR__ . '/../../../bootstrap.php';

use Sudoku\Data\Grid;
use Sudoku\View\Html\HtmlCell;
use Sudoku\View\Html\HtmlField;
use Sudoku\View\Html\HtmlFieldFactory;
use Sudoku\View\Html\HtmlRow;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see HtmlFieldFactory}.
 *
 * @package Sudoku\Tests\View\Html
 * @author  Roman Piller
 * @testCase
 */
final class HtmlFieldFactoryTest extends TestCase
{
    /** @var HtmlFieldFactory Testovana tovarna */
    private HtmlFieldFactory $factory;

    /** @inheritDoc */
    protected function setUp(): void
    {
        $this->factory = new HtmlFieldFactory();
    }

    /**
     * Test vytvorenia komponentov tovarne.
     *
     * @return void
     */
    public function testCreateComponents(): void
    {
        Assert::type(HtmlCell::class, $this->factory->createCell('5'));
        Assert::type(HtmlRow::class, $this->factory->createRow(1));
        Assert::type(HtmlField::class, $this->factory->createField());
    }

    /**
     * Test celkoveho vykreslenia mriezky do HTML.
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $grid = new Grid();
        $grid->setCell(0, 0, 1);
        
        $html = $this->factory->display($grid);
        
        Assert::contains('<table', $html);
        Assert::contains('1', $html);
        Assert::contains('<!DOCTYPE html>', $html);
    }
}

(new HtmlFieldFactoryTest())->run();
