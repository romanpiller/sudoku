<?php declare(strict_types=1);

namespace Sudoku\View\Abstract;

/**
 * Trieda Row
 *
 * @package Sudoku\View\Abstract
 * @author  Roman Piller
 */
abstract class Row
{
    /**
     * Pocet buniek na jeden riadok
     */
    public const COLUMNS = 9;

    /** @var Cell[] $cells */
    protected array $cells = [];

    /**
     * Vlozi pole buniek
     *
     * @param Cell $cell
     */
    public function addCell(Cell $cell): void
    {
        $this->cells[] = $cell;
    }

    /**
     * Vrati formatovany riadok
     *
     * @return string
     */
    abstract public function write(): string;
}
