<?php

namespace DmitryFedorov\ConsoleTest\Collections;

use DmitryFedorov\ConsoleTest\AbstractClasses\AbstractBaseCommand;

class CommandCollection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function checkValueForInstance($value): void
    {
        $className = AbstractBaseCommand::class;

        if (!$value instanceof $className) {
            throw new \InvalidArgumentException("Class not instance of class = {$className}");
        }
    }
}