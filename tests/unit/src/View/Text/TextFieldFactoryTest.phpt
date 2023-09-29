<?php declare(strict_types=1);

namespace Sudoku\Tests\View\Text;

require_once __DIR__ . '/../../../bootstrap.php';

use Sudoku\Data\Grid;
use Sudoku\View\Text\TextCell;
use Sudoku\View\Text\TextField;
use Sudoku\View\Text\TextFieldFactory;
use Sudoku\View\Text\TextRow;
use Tester\Assert;
use Tester\TestCase;

/**
 * Test {@see TextFieldFactory}.
 *
 * @package Sudoku\Tests\View\Text
 * @author  Roman Piller
 * @testCase
 */
final class TextFieldFactoryTest extends TestCase
{
    /** @var TextFieldFactory Testovana tovarna */
    private TextFieldFactory $factory;

    /** @inheritDoc */
    protected function setUp(): void
    {
        $this->factory = new TextFieldFactory();
    }

    /**
     * Test vytvorenia komponentov tovarne.
     *
     * @return void
     */
    public function testCreateComponents(): void
    {
        Assert::type(TextCell::class, $this->factory->createCell('5'));
        Assert::type(TextRow::class, $this->factory->createRow());
        Assert::type(TextField::class, $this->factory->createField());
    }

    /**
     * Test celkoveho vykreslenia mriezky do textu.
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $grid = new Grid();
        $grid->setCell(0, 0, 1);
        
        $text = $this->factory->display($grid);
        
        Assert::contains('1', $text);
        Assert::type('string', $text);
    }
}

(new TextFieldFactoryTest())->run();
