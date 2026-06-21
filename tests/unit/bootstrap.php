<?php declare(strict_types=1);

use Nette\DI\Container;
use Nette\DI\Extensions\ExtensionsExtension;

require __DIR__ . '/../../vendor/autoload.php';

Tester\Environment::setup();
Tester\Environment::bypassFinals();
date_default_timezone_set('Europe/Bratislava');

$containerLoader = new Nette\DI\ContainerLoader(__DIR__ . '/temp', true);

/** @var Container $container */
$container = $containerLoader->load(function ($compiler) {
    $compiler->addExtension('extensions', new ExtensionsExtension());
    $compiler->loadConfig(__DIR__ . '/src/Config/config.local.neon');
});

return new $container();
