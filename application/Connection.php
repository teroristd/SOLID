<?php

namespace application;

class Connection
{
    private $_config;

    public function __construct(Config $config)
    {
        $this->_config = $config;
    }

    public function getConnection()
    {
        $arr = $this->_config->getConfigFile('connectionArr');

        $pdo = new \PDO($arr['host'], $arr['username'], $arr['password'], $arr['options']);

        return $pdo;
    }
}