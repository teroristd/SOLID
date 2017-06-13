<?php

namespace application;

class Container
{
    private $_config;
    private $_cache = array ();

    public function __construct(Config $config)
    {
        $this->_config = $config;
    }

    public function make($class)
    {
        $reflector = new \ReflectionClass($class);

        if ($reflector->isInterface())
        {
            $interfaceName = $reflector->getShortName();

            $arr = $this->_config->getConfigFile('interfaceArr');

            foreach ($arr as $key => $val)
            {
                foreach ($val as $k => $v)
                {
                    if ($key == $interfaceName)
                    {
                        $class = $v;

                        break;
                    }
                }
            }
            $reflector = new \ReflectionClass($class);
        }

        if (!$reflector->isInstantiable())
        {
            $method = new \ReflectionMethod($class, '__construct');

            if ($method->isPrivate())
            {
                return $class::getInstance();
            }
            throw new \Exception('This Class ' . $class . ' Is Not Instantiable In: ' . __METHOD__, 500);
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor))
        {
            return new $class;
        }

        $parameters = $constructor->getParameters();

        $dependencies = array ();

        foreach ($parameters as $param)
        {
            $getClassName = $param->getClass();

            if (is_null($getClassName))
            {
                if ($param->isDefaultValueAvailable())
                {
                    $dependencies[] = $param->getDefaultValue();

                    break;
                }
                else
                {
                    throw new \Exception('This Parameter ' . $param . ' Is Not An Object And Is No Default Value: ' . __METHOD__, 500);
                }
            }
            else
            {
                $dependencies[] = $this->make($getClassName->getName());
            }
        }

        $cacheArr = $this->_config->getConfigFile('cacheArr');

        foreach ($cacheArr as $value)
        {
            if ($class == $value)
            {
                if ($value == 'application\Config')
                {
                    return $this->_config;
                }

                if (!isset($this->_cache[$class]))
                {
                    $this->_cache[$class] = $reflector->newInstanceArgs($dependencies);
                }
                return $this->_cache[$class];
            }
        }
        return $reflector->newInstanceArgs($dependencies);
    }
}