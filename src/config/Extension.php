<?php declare(strict_types=1);

namespace Sudoku\config;

use Nette\DI\CompilerExtension;
use Nette\DI\Config\Loader;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * Rozsirenie.
 *
 * @author Roman Piller
 */
final class Extension extends CompilerExtension
{
    /** @inheritDoc */
    public function getConfigSchema(): Schema
    {
        parent::getConfigSchema();
        return Expect::structure([
            'stdOut' => Expect::bool(false),
            'loadPath' => Expect::string()->required(),
            'savePath' => Expect::string()->required(),
        ]);
    }

    /** @inheritDoc */
    public function loadConfiguration(): void
    {
        parent::loadConfiguration();
        $loader = new Loader();
        $this->loadDefinitionsFromConfig(
            $loader->load(__DIR__ . '/config.neon')['services']
        );

        $facade = $this->getContainerBuilder()->getDefinition($this->prefix('sudoku'));
        $facade->setArguments([
            'loadPath' => $this->config->loadPath,
            'savePath' => $this->config->savePath,
            'stdOut' => $this->config->stdOut,
        ]);
    }
}
