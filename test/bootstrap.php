<?php

use YapepBase\Autoloader\AutoloaderRegistry;
use YapepBase\Autoloader\SimpleAutoloader;

require __DIR__ . '/../vendor/autoload.php';

// Set up the autoloader
$autoLoader = new SimpleAutoloader();
$autoLoader->addClassPath(realpath(__DIR__ . '/../src/'));
$autoLoader->addClassPath(realpath(__DIR__));
AutoloaderRegistry::getInstance()->addAutoloader($autoLoader);

// Clean up the global namespace
unset($autoLoader);
