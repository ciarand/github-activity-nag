<?php

namespace Ciarand\GithubActivityNag\Naggers;

use Ciarand\GithubActivityNag\Naggers\NaggingInterface;

class ExitCode implements NaggingInterface
{
    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function __construct(array $config)
    {

    }

    public function run($isLazy)
    {
        $exitCode = (int) $isLazy;
        exit($exitCode);
    }
}
