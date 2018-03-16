<?php

namespace application\sessions;

use application\Config;

class SessionConnect
{
    private $_config;
    private $_arr;
    public $_sessionName;
    public $_tableName;
    public $_lifetime;
    public $_path;
    public $_domain;
    public $_secure;
    public $_sessionId = null;
    public $_cookie;

    public function __construct(Config $config)
    {
        $this->_config = $config;

        $this->_arr = $this->_config->getConfigFile('sessionArr');

        $this->sessionRun($this->_arr['name'], $this->_arr['lifetime'], $this->_arr['path'], $this->_arr['secure'], $this->_arr['table'], $this->_arr['domain']);
    }

    public function sessionRun($name, $lifetime, $path, $secure, $table, $domain)
    {
        $this->_sessionName = $name;

        $this->_tableName = $table;

        $this->_lifetime = $lifetime;

        $this->_path = $path;

        $this->_domain = $domain;

        $this->_secure = $secure;

        $this->_cookie = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_STRING);

        if (isset($this->_cookie))
        {
            $this->_sessionId = $this->_cookie;
        }
    }
}