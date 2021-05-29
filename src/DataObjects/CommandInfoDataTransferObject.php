<?php

namespace DmitryFedorov\ConsoleTest\DataObjects;

use DmitryFedorov\ConsoleTest\Collections\CommandOptionCollection;

class CommandInfoDataTransferObject
{
     /**
      *
      * @var CommandOptionCollection
      */
    public CommandOptionCollection $options;

     /**
      *
      * @var array
      */
    public array $agruments = [];

    /**
      *
      * @var bool
      */
    public bool $hasHelpArgument = false;

     /**
      *
      * @var string
      */
    public string $name;
}
