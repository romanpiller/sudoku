<?php

declare(strict_types=1);

namespace Sudoku\Exceptions;

use InvalidArgumentException;

/**
 * Nevalidne vstupne examples, nesedi pocet cisel v zadani.
 *
 * @package Sudoku\Exceptions
 * @author  Roman Piller
 */
final class InvalidCountException extends InvalidArgumentException
{
}
