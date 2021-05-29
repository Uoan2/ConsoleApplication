<?php

namespace DmitryFedorov\ConsoleTest\Processors;

use DmitryFedorov\ConsoleTest\DataObjects\CommandInfoDataTransferObject;
use DmitryFedorov\ConsoleTest\Parsers\CommandParser;

/**
 * Class CommandInputProcessor
 */
final class CommandInputProcessor
{
    /**
     *
     * @param array $outputFromLine
     * @return CommandInfoDataTransferObject
     */
    public function handle(string $outputFromLine): ?CommandInfoDataTransferObject
    {
        $params = explode(' ', $outputFromLine);

        if (count($params) < 1) {
            return null;
        }

        return (new CommandParser())->parse($params);
    }
}
