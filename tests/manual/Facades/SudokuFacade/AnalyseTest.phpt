<?php declare(strict_types=1);

use Nette\DI\Container;
use Sudoku\Facades\SudokuFacade;
use Tester\Assert;

/*
 * Manualny test celeho precesu riesenia sudoku.
 * Aj vypisom zadania a riesnia a aj ulozenim riesenia na disk.
 */

/** @var Container $container */
$container = require __DIR__ . '/../../bootstrap.php';
$facade = $container->getByType(SudokuFacade::class);

Assert::true($facade->solve(
    'example-hard.txt',
    __DIR__ . '/../../examples',
    true,
    'example-hard.html',
    __DIR__ . '/../../temp'
), 'Nepodarilo sa vyriesit sudoku');
