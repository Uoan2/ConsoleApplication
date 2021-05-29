<?php

namespace DmitryFedorov\ConsoleTest\Repositories;

use DmitryFedorov\ConsoleTest\Collections\CommandCollection;
use DmitryFedorov\ConsoleTest\DataCollectors\CommandClassesCollector;
use DmitryFedorov\ConsoleTest\DataCollectors\FilePathsCollector;
use DmitryFedorov\ConsoleTest\AbstractClasses\AbstractBaseCommand;

class CommandRepository
{
    private CommandClassesCollector $commandClassesCollector;

    private array $paths;

    public function __construct()
    {
        $this->commandClassesCollector = new CommandClassesCollector();
        $this->paths = FilePathsCollector::getPaths();
    }
    /**
     *
     * @return CommandCollection
     */
    public function getCommands(): CommandCollection
    {
        $arrayOfClasses = $this->commandClassesCollector->find($this->paths);

        $collection = $this->setDataToObjectCollection($arrayOfClasses, new CommandCollection());

        $this->uniqueValidation($collection);

        return $collection;
    }

    /**
     *
     * @param array $data
     * @param CommandCollection $collection
     * @return CommandCollection
     */
    private function setDataToObjectCollection(array $data, CommandCollection $collection): CommandCollection
    {
        foreach ($data as $value) {
            $collection->offsetSet($this->createCommand($value));
        }

        return $collection;
    }

    /**
     *
     * @param string $className
     * @return AbstractBaseCommand
     */
    private function createCommand(string $className): AbstractBaseCommand
    {
        return new $className();
    }

    /**
     *
     * @param CommandCollection $commandCollection
     * @return void
     */
    private function uniqueValidation(CommandCollection $commandCollection): void
    {
        foreach ($commandCollection as $key => $command) {
            $commandName = $command->getName();
            foreach ($commandCollection as $key1 => $secondCommand) {
                if ($commandName === $secondCommand->getName() && $key1 != $key) {
                    throw new \InvalidArgumentException("Command name must be unique, change name of command $commandName");
                }
            }
        }
    }
}
