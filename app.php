<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new Exception(
        "Composer dependencies have not been updated. Run 'composer install'.",
        1
    );
}

require __DIR__ . '/vendor/autoload.php';

$application = new Ciarand\GithubActivityNag\Application();
$application->run();
