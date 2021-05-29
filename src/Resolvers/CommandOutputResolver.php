<?php

namespace DmitryFedorov\ConsoleTest\Resolvers;

use DmitryFedorov\ConsoleTest\DataObjects\CommandInfoDataTransferObject;
use DmitryFedorov\ConsoleTest\Collections\CommandCollection;
use DmitryFedorov\ConsoleTest\AbstractClasses\AbstractBaseCommand;

/**
 * Class CommandOutputResolver
 */
final class CommandOutputResolver
{

    private const BASE_RED_COLOUR = "\e[91m";

    private const BASE_YELLOW_COLOUR = "\e[93m";

    private const BASE_BLUE_COLOUR = "\e[36m";

    private CommandCollection $commandCollection;

    private ?CommandInfoDataTransferObject $commandInfoDataTransferObject;


    /**
     *
     * @param CommandCollection $commandCollection
     * @param CommandInfoDataTransferObject|null $commandInfoDataTransferObject
     */
    public function __construct(
        CommandCollection $commandCollection,
        ?CommandInfoDataTransferObject $commandInfoDataTransferObject
    ) {
        $this->commandCollection = $commandCollection;
        $this->commandInfoDataTransferObject = $commandInfoDataTransferObject;
    }

    /**
     *
     * @return string
     */
    public function handle(): string
    {
        if (is_null($this->commandInfoDataTransferObject)) {
            return $this->getAllCommandsOutput();
        }

        $command = $this->findCommand($this->commandInfoDataTransferObject);

        if (is_null($command)) {
            return $this->getAllCommandsOutput();
        }

        $command->handle();

        return $this->getOutput($command);
    }

    /**
     *
     * @return string
     */
    private function getAllCommandsOutput(): string
    {
        $output = self::BASE_RED_COLOUR . "Available commands:" . PHP_EOL . "\t" .  'Name:' . "\t" . "Description:" . PHP_EOL;

        foreach ($this->commandCollection as $commandCollection) {
            $output .= self::BASE_BLUE_COLOUR . "\t" . $commandCollection->getName() . "\t" .  self::BASE_YELLOW_COLOUR . $commandCollection->getDescription() . PHP_EOL;
        }
        return $output;
    }

    /**
     *
     * @param CommandInfoDataTransferObject $commandInfoDataTransferObject
     * @return AbstractBaseCommand|null
     */
    private function findCommand(CommandInfoDataTransferObject $commandInfoDataTransferObject): ?AbstractBaseCommand
    {
        $command = null;
        foreach ($this->commandCollection as $commmandObj) {
            if ($commmandObj->getName() ==  $commandInfoDataTransferObject->name) {
                $command = $commmandObj;
                $command->setCommandInfoDataTransferObject($this->commandInfoDataTransferObject);
                return $command;
            }
        }

        return $command;
    }


    /**
     *
     * @param AbstractBaseCommand $command
     * @return string
     */
    private function getOutput(AbstractBaseCommand $command): string
    {
        $commandInfoDataTransferObject = $command->getCommandInfoDataTransferObject();
        $output = '';
        $output = self::BASE_RED_COLOUR . 'CalledCommand: ' . self::BASE_BLUE_COLOUR . $command->getName() . PHP_EOL;
        if (!empty((($commandInfoDataTransferObject->hasHelpArgument)))) {
            $output .= self::BASE_RED_COLOUR . "Description: " . self::BASE_BLUE_COLOUR .  $command->getDescription()  . \PHP_EOL;
        }

        if (!empty($commandInfoDataTransferObject->agruments)) {
            $output .= self::BASE_RED_COLOUR . "Arguments:" .  self::BASE_BLUE_COLOUR  . \PHP_EOL;

            foreach ($commandInfoDataTransferObject->agruments as $agrument) {
                $output .= "\t - " . $agrument . " \n";
            }
        }

        if (!empty($commandInfoDataTransferObject->options->collection)) {
            $output .=  self::BASE_RED_COLOUR . "Options:" .  PHP_EOL .  self::BASE_BLUE_COLOUR;

            foreach ($commandInfoDataTransferObject->options as $option) {
                $output .=  "\t - " . $option->name . PHP_EOL . "\t  " . self::BASE_RED_COLOUR . "Option Arguments:"
                    . self::BASE_BLUE_COLOUR . PHP_EOL;
                foreach ($option->values as $value) {
                    $output .= "\t \t - " . $value . " \n";
                }
            }
        }
        return $output;
    }
}
