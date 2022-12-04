#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Zkelo\Archivarius\Commands\AboutCommand;

/**
 * Application name
 */
const APP_NAME = 'Archivarius';

/**
 * Application version
 */
const APP_VERSION = '1.0';

$app = new Application(APP_NAME, APP_VERSION);

$app->add(new AboutCommand);

$app->run();
