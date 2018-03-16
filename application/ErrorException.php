<?php

namespace application;

use application\routers\DefaultRouter;

class ErrorException
{
    private $_config;
    private $_view;
    private $_defaultRouter;
    private $_link;

    public function __construct(Config $config, View $view, DefaultRouter $defaultRouter)
    {
        $this->_config = $config;

        $this->_view = $view;

        $this->_defaultRouter = $defaultRouter;

        $this->_link = $this->_defaultRouter->link();

        set_exception_handler(array($this, 'exceptionHandler'));
    }

    public function exceptionHandler(\Throwable $exception)
    {
        $code = $exception->getCode();

        $conf = $this->_config->getConfigFile('exArr');

        if ($this->_config && $conf['exception'] == true)
        {
            echo '<pre>' . print_r($exception, true) . '</pre>';
        }
        else
        {
            if ($code === 404)
            {
                header("Location:" . $this->_link . "/error404/");
            }
            else
            {
                header("Location:" . $this->_link . "/error500/");
            }
        }
    }
}