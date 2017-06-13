<?php

namespace application;

class Config
{
    public function getConfigFile($name)
    {
        $folderPath = realpath(str_replace(substr(__DIR__, strrpos(__DIR__, DIRECTORY_SEPARATOR) + 1), '', __DIR__) . 'config') . DIRECTORY_SEPARATOR;

        if ($folderPath == false && !is_dir($folderPath) && !is_readable($folderPath))
        {
            throw new \Exception('Folder config Is Missing Or You Have No Write Premissions: ' . __METHOD__, 500);
        }

        if (strlen(trim($name)) <= 0)
        {
            throw new \Exception('You Have No Set The Name Of File: ' . __METHOD__, 500);
        }

        $filePath = realpath($folderPath . $name . '.php');

        if ($filePath == false && !is_file($filePath) && !is_readable($filePath))
        {
            throw new \Exception('Config File Is Missing Or You Have No Write Premissions' . __METHOD__, 500);
        }

        if (!isset($configArray[$name]))
        {
            $configArray[$name] = require $filePath;
        }

        if (array_key_exists($name, $configArray))
        {
            return $configArray[$name];
        }
    }
}