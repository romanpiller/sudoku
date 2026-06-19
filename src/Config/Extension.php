<?php declare(strict_types=1);

namespace Sudoku\Config;

use Nette\DI\CompilerExtension;
use Nette\DI\Config\Loader;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;

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
        $builder = $this->getContainerBuilder();
        $loader = new Loader();
        $neonConfig = $loader->load(__DIR__ . '/config.neon');

        if (is_array($neonConfig) && isset($neonConfig['services']) && is_array($neonConfig['services'])) {
            $this->loadDefinitionsFromConfig($neonConfig['services']);
        }

        $facade = $builder->getDefinition($this->prefix('sudoku'));

        /** @var stdClass $extensionConfig */
        $extensionConfig = $this->config;

        if ($facade instanceof ServiceDefinition) {
            $facade->setArguments([
                'loadPath' => $extensionConfig->loadPath,
                'savePath' => $extensionConfig->savePath,
                'stdOut' => $extensionConfig->stdOut,
            ]);
        }
    }
}
