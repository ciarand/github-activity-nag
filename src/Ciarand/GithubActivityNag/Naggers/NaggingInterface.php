<?php

namespace Ciarand\GithubActivityNag\Naggers;

interface NaggingInterface
{
    public function __construct(array $config);
    public function run($isLazy);
}
