<?php declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Nette\DI\ContainerLoader;
use Nette\DI\Extensions\ExtensionsExtension;
use Tester\Environment;
use Tester\Helpers;

Environment::setup();
Environment::bypassFinals();
date_default_timezone_set('Europe/Bratislava');

Helpers::purge(__DIR__ . '/temp');
$containerLoader = new ContainerLoader(__DIR__ . '/temp', true);

$container = $containerLoader->load(function ($compiler) {
    $compiler->addExtension('extensions', new ExtensionsExtension());
    $compiler->loadConfig(__DIR__ . '/Config/config.local.neon');
});

return new $container();
