<?php

use App\Container\Provider;
use App\Container\TemplateEmitterProvider;
use Sx\Config\ConfigProvider;
use Sx\Container\Injector;

$baseDirectory = dirname(__DIR__, 2);
// Activate composer auto-loading.
require "$baseDirectory/vendor/autoload.php";

// Load configuration from the config dir. All files are merged in alphabetical order.
// The example actually only requires the database configuration.
$configProvider = new ConfigProvider();
$configProvider->loadFiles("$baseDirectory/config/*.php");
$options = $configProvider->getConfig();

$injector = new Injector($options);
// Provide at least the factories to create the template emitters with all dependencies.
$injector->setup(new Provider());
// Register the template implementations that create rendered output.
$injector->setup(new TemplateEmitterProvider());

// Render the template.
include __DIR__ . '/../template.phtml';
