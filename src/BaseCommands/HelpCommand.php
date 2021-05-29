<?php

namespace DmitryFedorov\ConsoleTest\BaseCommands;

use DmitryFedorov\ConsoleTest\AbstractClasses\AbstractBaseCommand;

/**
 * Class HelpCommand
 */
class HelpCommand extends AbstractBaseCommand
{
    /**
     * The name of command
     *
     * @var string
     */
    protected string $name = 'help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Call help';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    }
}
