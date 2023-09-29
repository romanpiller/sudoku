<?php declare(strict_types=1);

namespace Sudoku\View\Abstract;

/**
 * Jedna bunka
 *
 * @package Sudoku\View\Abstract
 * @author  Roman Piller
 */
abstract class Cell
{
    /**
     * Konstruktor
     *
     * @param string $content
     */
    public function __construct(protected string $content)
    {
    }

    /**
     * Vrati formatovane cislo
     *
     * @return string
     */
    abstract public function write(): string;
}
