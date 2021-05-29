<?php

namespace DmitryFedorov\ConsoleTest\Parsers;

use DmitryFedorov\ConsoleTest\DataObjects\CommandInfoDataTransferObject;
use DmitryFedorov\ConsoleTest\Collections\CommandOptionCollection;
use DmitryFedorov\ConsoleTest\DataObjects\CommandOptionDataTransferObject;

/**
 * Class CommandParser
 */
final class CommandParser
{

    private CommandInfoDataTransferObject $commandInfoDataTransferObject;

    private CommandOptionCollection $commandOptionCollection;

    private $params;

    public function __construct()
    {
        $this->commandInfoDataTransferObject = new CommandInfoDataTransferObject();
        $this->commandOptionCollection = new CommandOptionCollection();
    }

    /**
     *
     * @param array $params
     * @return CommandInfoDataTransferObject|null
     */
    public function parse(array $params): ?CommandInfoDataTransferObject
    {
        $this->params = array_unique($params);

        $this->commandInfoDataTransferObject->name = array_shift($this->params);
        if (!empty($this->params)) {
            $this->commandInfoDataTransferObject->options = $this->parseOptions();

            $this->commandInfoDataTransferObject->agruments = $this->parseArguments($this->params);

            $this->commandInfoDataTransferObject->hasHelpArgument =
                $this->findHelpArgument($this->commandInfoDataTransferObject->agruments);
        }

        return $this->commandInfoDataTransferObject;
    }

    /**
     *
     * @param array $agruments
     * @return boolean
     */
    private function findHelpArgument(array $agruments): bool
    {
        return (array_search('help', $agruments) !== false);
    }

    /**
     *
     * @return CommandOptionCollection
     */
    private function parseOptions(): CommandOptionCollection
    {
        $options = [];
        $optionsArray = [];
        foreach ($this->params as $key => $param) {
            if (preg_match('/\[([^\)]*)\]/', $param, $options) !== 0) {
                unset($this->params[$key]);
                $optionsArray[] = $options[1];
            }
        }
        foreach ($optionsArray as $key => $option) {
            $multipleArray = explode('=', $option);

            if (count($multipleArray) < 2) {
                continue;
            }

            $name = $multipleArray[0];
            $commandOptionDataTransferObject = (new CommandOptionDataTransferObject());
            $commandOptionDataTransferObject->name = $name;
            $commandOptionDataTransferObject->values =  $this->parseValues($multipleArray[1]);
            if (!empty($commandOptionDataTransferObject->values)) {
                $this->commandOptionCollection->offsetSet($commandOptionDataTransferObject);
            }
        }
        return $this->commandOptionCollection;
    }

    /**
     *
     * @param array  $param
     * @return array
     */
    private function parseValues(string $param): array
    {
        $values = [];
        $valuesArray = [];

        if (preg_match('/\{([^\)]*)\}/', $param, $values) === false) {

            return $values;
        }

        $value = $values[1];
        $multipleArguments = explode(',', $value);
        if (count($multipleArguments) > 1) {
            foreach ($multipleArguments as $multipleArgument) {
                $valuesArray[] = $multipleArgument;
            }
            return $valuesArray;
        }
        return [];
    }


    /**
     *
     * @param array $params
     * @return array
     */
    private function parseArguments(array $params): array
    {
        $arguments = [];
        $argumentArray = [];
        foreach ($params as $key => $param) {

            if (preg_match('/\{([^\)]*)\}/', $param, $arguments) !== 0) {
                unset($this->params[$key]);
                $argumentArray[] = $arguments[1];
            }
        }
        $arguments = [];
        foreach ($argumentArray as $key => $argument) {
            $multipleArguments = explode(',', $argument);
            if (count($multipleArguments) > 1) {
                unset($arguments[$key]);
                foreach ($multipleArguments as $multipleArgument) {
                    $arguments[] = $multipleArgument;
                }
            } else {
                $arguments[] = $argument;
            }
        }
        return array_unique($arguments);
    }
}
