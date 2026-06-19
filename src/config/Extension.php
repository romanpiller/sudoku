<?php declare(strict_types=1);

namespace Sudoku\config;

use Nette\DI\CompilerExtension;

/**
 * Rozsirenie.
 *
 * @author Roman Piller
 */
final class Extension extends CompilerExtension
{
    /** @inheritDoc */
    public function loadConfiguration(): void
    {
        parent::loadConfiguration();
        $this->compiler->loadConfig(__DIR__ . '/config.neon');
    }
}
