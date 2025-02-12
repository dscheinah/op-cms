<?php

use App\Container\Provider;
use App\Container\TemplateEmitterProvider;
use Sx\Config\ConfigProvider;
use Sx\Container\Injector;

$baseDirectory = dirname(__DIR__, 2);
require "$baseDirectory/vendor/autoload.php";

$configProvider = new ConfigProvider();
$configProvider->loadFiles("$baseDirectory/config/*.php");
$options = $configProvider->getConfig();

$injector = new Injector($options);
$injector->setup(new Provider());
$injector->setup(new TemplateEmitterProvider());

include __DIR__ . '/../template.phtml';
