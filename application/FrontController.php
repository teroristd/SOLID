<?php

namespace application;

use application\routers\DefaultRouter;

class FrontController
{
    private $_config;
    private $_defaultRouter;
    private $_routerArr;
    private $_defaultParam;
    private $_URL;
    private $_namespace;
    private $_controller;
    private $_method;
    private $_params;
    private $_file;
    private $_load;
    private $_container;

    public function __construct(Config $config, DefaultRouter $defaultRouter, Container $container)
    {
        $this->_config = $config;

        $this->_defaultRouter = $defaultRouter;

        $this->_container = $container;

        $this->_routerArr = $this->_config->getConfigFile('routerArr');

        $this->_defaultParam = $this->_config->getConfigFile('appArr');

        $this->_URL = $this->_defaultRouter->getUrl();
    }

    private function getNamespace()
    {
        if (is_array($this->_routerArr) && $this->_routerArr > 0)
        {
            foreach ($this->_routerArr as $key => $val)
            {
                if (stripos($this->_URL, $key) === 0 && ($this->_URL == $key || stripos($this->_URL, $key . '/') === 0) && $val)
                {
                    $this->_namespace = $val;

                    break;
                }
            }
        }
        else
        {
            throw new \Exception('Router Array Do Not Exist In: ' . __METHOD__, 500);
        }
    }

    private function isExistNamespace()
    {
        if ($this->_namespace === null && $this->_routerArr['*'])
        {
            $this->_namespace = $this->_routerArr['*'];
        }
        elseif ($this->_namespace === null && !$this->_routerArr['*'])
        {
            throw new \Exception('Default Root Missing In: ' . __METHOD__, 500);
        }
    }

    private function isControllerExist()
    {
        if (!class_exists($this->_namespace . DIRECTORY_SEPARATOR . $this->_controller))
        {
            throw new \Exception('There No Such Controller In: ' . __METHOD__, 404);
        }
    }

    private function isMethodExist()
    {
        if (!method_exists($this->_namespace . DIRECTORY_SEPARATOR . $this->_controller, $this->_method))
        {
            throw new \Exception('There No Such Method In: ' . __METHOD__, 404);
        }
    }

    private function params()
    {
        $this->_params = explode('/', $this->_URL);

        if (!empty($this->_params[1]))
        {
            $this->_controller = strtolower($this->_params[1]);

            $this->isControllerExist();

            if (!empty($this->_params[2]))
            {
                $this->_method = strtolower($this->_params[2]);

                $this->isMethodExist();

                unset($this->_params[1], $this->_params[2]);
            }
            else
            {
                $this->_method = strtolower($this->_defaultParam[2]);
            }
        }
        else
        {
            $this->_controller = strtolower($this->_defaultParam[0]);

            $this->_method = strtolower($this->_defaultParam[1]);
        }

        $this->_file = $this->_namespace . DIRECTORY_SEPARATOR . ucfirst($this->_controller);

        $this->_load = $this->_container->make($this->_file);

        $this->_load->{$this->_method}();
    }

    public function output()
    {
        $this->getNamespace();

        $this->isExistNamespace();

        $this->params();
    }
}