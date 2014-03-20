<?php
/* @var $loader Composer\Autoload\ClassLoader */
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Tests\\', __DIR__);

require_once 'PHPUnit/Framework/Assert/Functions.php';
