<?php

namespace application;

use application\interfaces\ISession;

class App
{
    private $_config;
    private $_sessionInterface;
    private $_sessionType;

    public function __construct(Config $config, ISession $sessionInterface)
    {
        $this->_config = $config;

        $this->_sessionInterface = $sessionInterface;
    }

    public function appRun()
    {
        $sessArr = $this->_config->getConfigFile('sessionArr');

        if ($sessArr['autostart'] == true)
        {
            if ($sessArr['type'] == 'default')
            {
                $this->_sessionType = $this->_sessionInterface->sessionRun($sessArr['name'], $sessArr['lifetime'], $sessArr['path'], $sessArr['secure']);
            }
            elseif ($sessArr['type'] == 'database')
            {
                $this->_sessionType = $this->_sessionInterface->sessionRun($sessArr['name'], $sessArr['lifetime'], $sessArr['path'], $sessArr['secure'], $sessArr['dbConnection'], $sessArr['table']);
            }
            else
            {
                throw new \Exception('No Valid Session In: ' . __METHOD__, 500);
            }
        }
    }
}