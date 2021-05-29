<?php

namespace DmitryFedorov\ConsoleTest\DataCollectors;

use DmitryFedorov\ConsoleTest\AbstractClasses\AbstractBaseCommand;

/**
 * Class CommandFinder
 */
final class CommandClassesCollector
{
    /**
     * The array of paths
     *
     * @var array
     */
    private string $baseCommandsPath = 'vendor/dmitry-fedorov/console-test/src/BaseCommands/';

    /**
     * The array of classes
     *
     * @var array
     */
    private array $classes = [];

    /**
     *
     * @param array $paths
     * @return array
     */
    public function find(array $paths): array
    {
        $paths = $this->addBasePath($paths);

        foreach ($paths as $path) {
            $this->findInSpecificDirectory($path);
        }

        return $this->classes;
    }

    /**
     *
     * @param array $paths
     * @return array
     */
    private function addBasePath(array $paths): array
    {
        $paths[] = $this->baseCommandsPath;
        return $paths;
    }

    /**
     *
     * @param string $string
     * @return void
     */
    private function findInSpecificDirectory(string $string): void
    {
        $files = glob($string . "*.php");
        foreach ($files as $file) {
            $classesBefore = (get_declared_classes());
            require_once $file;
            $classesAfter = (get_declared_classes());
            $class = basename($file, '.php');

            $classDiffs = array_diff($classesAfter, $classesBefore);

            foreach ($classDiffs as $classDiff) {
                $className = '';
                if (stristr($classDiff, $class) !== false) {
                    $className = $classDiff;
                    break;
                }
            }
            if (class_exists($className) && is_subclass_of($className, AbstractBaseCommand::class)) {
                $this->classes[] = $className;
            }
        }
    }
}
