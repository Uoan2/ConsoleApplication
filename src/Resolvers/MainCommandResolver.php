<?php

namespace DmitryFedorov\ConsoleTest\Resolvers;

use DmitryFedorov\ConsoleTest\Processors\CommandInputProcessor;
use DmitryFedorov\ConsoleTest\Repositories\CommandRepository;
use DmitryFedorov\ConsoleTest\Resolvers\CommandOutputResolver;

/**
 * Class MainCommandResolver
 */
final class MainCommandResolver
{
    /**
     *
     * @param string $outputFromLine
     * @param CommandInputProcessor $commandInputProcessor
     * @param CommandRepository $commandRepository
     * @return string
     */
    public function handle(
        string $outputFromLine,
        CommandInputProcessor $commandInputProcessor,
        CommandRepository $commandRepository
    ): string {
        $commandInfoDataTransferObject = $commandInputProcessor->handle($outputFromLine);
        $commandCollection = $commandRepository->getCommands();

        $output =  (new CommandOutputResolver($commandCollection, $commandInfoDataTransferObject))->handle();

        return $output;
    }
}
