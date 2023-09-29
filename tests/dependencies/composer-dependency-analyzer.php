<?php declare(strict_types = 1);

/**
 * https://github.com/shipmonk-rnd/composer-dependency-analyser
 */

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;

$config = new Configuration();

return $config
  ->addPathToScan(__DIR__ . '/../../src', false)
  ->addPathToScan(__DIR__ . '/../../tests/manual', true)
  ->addPathToScan(__DIR__ . '/../../tests/unit', true)
  ->addPathToExclude(__DIR__ . '/../../tests/manual/temp')
  ->addPathToExclude(__DIR__ . '/../../tests/unit/temp');
