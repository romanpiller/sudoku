<?php declare(strict_types=1);

namespace Sudoku\View;

use Sudoku\Data\Grid;
use Sudoku\View\Html\HtmlFieldFactory;
use Sudoku\View\Text\TextFieldFactory;

/**
 * Vypise mriezku
 *
 * @package Sudoku\View
 * @author  Roman Piller
 */
final readonly class ViewService
{
    /**
     * Konstruktor
     */
    public function __construct(
        private TextFieldFactory $textFieldFactory,
        private HtmlFieldFactory $htmlFieldFactory,
    ) {
    }

    /**
     * Transformuje mriezku na textovy format
     */
    public function formatAsText(Grid $grid): string
    {
        return $this->textFieldFactory->display($grid);
    }

    /**
     * Transformuje mriezku na html format
     */
    public function formatAsHtml(Grid $grid): string
    {
        return $this->htmlFieldFactory->display($grid);
    }

    /**
     * Ulozi mriezku ako html subor
     */
    public function saveAsHtml(Grid $grid, string $filename): void
    {
        file_put_contents($filename, $this->formatAsHtml($grid));
    }
}
