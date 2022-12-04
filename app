#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Zkelo\Archivarius\Commands\{
    AboutCommand,
    ClearCommand,
    HashCommand
};

/**
 * Application name
 */
const APP_NAME = 'Archivarius';

/**
 * Application version
 */
const APP_VERSION = '1.0';

/**
 * Data directory name
 */
const DATA_DIRECTORY = 'data';

$app = new Application(APP_NAME, APP_VERSION);

$app->add(new AboutCommand);
$app->add(new HashCommand);
$app->add(new ClearCommand);

$app->run();
