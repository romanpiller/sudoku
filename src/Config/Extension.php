<?php declare(strict_types=1);

namespace Sudoku\Config;

use Nette\DI\CompilerExtension;
use Nette\DI\Config\Loader;

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
        $builder = $this->getContainerBuilder();
        $loader = new Loader();
        $neonConfig = $loader->load(__DIR__ . '/config.neon');

        if (is_array($neonConfig) && isset($neonConfig['services']) && is_array($neonConfig['services'])) {
            $this->loadDefinitionsFromConfig($neonConfig['services']);
        }
    }
}
