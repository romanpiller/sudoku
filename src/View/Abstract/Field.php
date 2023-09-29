<?php

declare(strict_types=1);

namespace Sudoku\View\Abstract;

/**
 * Trieda Field
 *
 * @package Sudoku\View\Abstract
 * @author  Roman Piller
 */
abstract class Field
{
    /** @var Row[] $rows */
    protected array $rows = [];

    /**
     * Prida riadok do pola
     *
     * @param Row $row
     */
    public function addRow(Row $row): void
    {
        $this->rows[] = $row;
    }

    /**
     * Vrati formatovane pole
     *
     * @return string
     */
    abstract public function write(): string;
}
