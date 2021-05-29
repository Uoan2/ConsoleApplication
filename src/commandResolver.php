<?php

use DmitryFedorov\ConsoleTest\Resolvers\MainCommandResolver;
use DmitryFedorov\ConsoleTest\Processors\CommandInputProcessor;
use DmitryFedorov\ConsoleTest\Repositories\CommandRepository;

require 'vendor/autoload.php';

$argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : array();

$output = (new MainCommandResolver())->handle($argv[1], new CommandInputProcessor(), new CommandRepository());

echo $output;
