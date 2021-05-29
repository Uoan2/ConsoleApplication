<?php

namespace DmitryFedorov\ConsoleTest\AbstractClasses;

use DmitryFedorov\ConsoleTest\DataObjects\CommandInfoDataTransferObject;

/**
 * Class AbstractBaseCommand
 */
abstract class AbstractBaseCommand
{
    /**
     * The name of command
     *
     * @var string
     */
    protected string $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description;


    /**
     * Dto object
     *
     * @var CommandInfoDataTransferObject $commandInfoDto
     */
    protected CommandInfoDataTransferObject $commandInfoDto;


    /**
     * Execute the console command.
     */
    abstract public function handle();

    /**
     *
     * @param CommandInfoDataTransferObject $commandInfoDto
     * @return void
     */
    final public function setCommandInfoDataTransferObject(CommandInfoDataTransferObject $commandInfoDto): void
    {
        $this->commandInfoDto = $commandInfoDto;
    }

    /**
     *
     * @return CommandInfoDataTransferObject
     */
    final public function getCommandInfoDataTransferObject(): CommandInfoDataTransferObject
    {
        return $this->commandInfoDto;
    }


    /**
     *
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    final public function getDescription(): string
    {
        return $this->description;
    }
}
