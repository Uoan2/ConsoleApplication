<?php

namespace DmitryFedorov\ConsoleTest\Collections;

use DmitryFedorov\ConsoleTest\DataObjects\CommandOptionDataTransferObject;

class CommandOptionCollection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function checkValueForInstance($value): void
    {
        $className = CommandOptionDataTransferObject::class;

        if (!$value instanceof $className) {
            throw new \InvalidArgumentException("Class not instance of class = {$className}");
        }
    }
}
