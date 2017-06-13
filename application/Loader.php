<?php

namespace application;

class Loader
{
    private $_config;
    private $_namespace = array ();

    public function __construct(Config $config)
    {
        $this->_config = $config;
    }

    private function regAutoload()
    {
        spl_autoload_register(array (DIRECTORY_SEPARATOR . __CLASS__, 'autoload'));
    }

    private function regNamespace($name, $path)
    {
        if (strlen(trim($name)) <= 0 && strlen(trim($path)) <= 0)
        {
            throw new \Exception('Invalid Name Or Path Param In: ' . __METHOD__, 500);
        }

        $path = realpath($path);

        if ($path == false && !is_dir($path) && !is_readable($path))
        {
            throw new \Exception('Loader Directory Read Error In: ' . __METHOD__, 500);
        }

        $this->_namespace[$name . '\\'] = $path . DIRECTORY_SEPARATOR;
    }

    protected function autoload($class)
    {
        foreach ($this->_namespace as $key => $value)
        {
            if (strpos($class, $key) === 0)
            {
                $file = realpath(substr_replace(str_replace('\\', DIRECTORY_SEPARATOR, $class), $value, 0, strlen($key)) . '.php');

                if ($file == false && !is_file($file) && !is_readable($file))
                {
                    throw new \Exception('File Is Missing Or You Have No Write Premissions' . __METHOD__, 500);
                }

                require_once $file;

                break;
            }
        }
    }

    public function load()
    {
        $namespaceArr = $this->_config->getConfigFile('namespaceArr');

        $this->regAutoload();

        $this->regNamespace(__NAMESPACE__, __DIR__ . DIRECTORY_SEPARATOR);

        for ($i = 0; $i < count($namespaceArr); $i++)
        {
            $this->regNamespace($namespaceArr[$i], str_replace(substr(__DIR__, strrpos(__DIR__, DIRECTORY_SEPARATOR) + 1), '', __DIR__) . $namespaceArr[$i]);
        }
    }
}