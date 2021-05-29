<?php

namespace DmitryFedorov\ConsoleTest\DataCollectors;

/**
 * Class FilePathsCollector
 */
final class FilePathsCollector
{
    private static array $baseIncludedCommandsPath = ['App/Commands'];

    private static string $configPath = 'dmitry-fedorov-console-config.php';

    /**
     *
     * @return array
     */
    public static function getPaths(): array
    {

        if (file_exists(self::$configPath)) {
            $config = include(self::$configPath);
            $config = $config['additional_paths_for_commands'];
            if (!empty($config)) {
                return $config;
            }
        }
        return self::$baseIncludedCommandsPath;
    }
}
