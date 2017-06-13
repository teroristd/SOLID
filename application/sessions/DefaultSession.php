<?php

namespace application\sessions;

use application\interfaces\ISession;

class DefaultSession implements ISession
{
    public function sessionRun($name, $lifetime, $path, $secure, $dbConnection = null, $tableName = null, $domain = null)
    {
        if (strlen($name) < 1)
        {
            $name = '_sess';
        }

        session_name($name);

        // Arguments always must be in this order
        session_set_cookie_params($lifetime, $path, $domain, $secure, true);

        session_start();
    }

    public function setSessionData($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function getSessionData($name)
    {
        return $_SESSION[$name];
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function saveSession()
    {
        session_write_close();
    }

    public function destroySession()
    {
        session_destroy();
    }
}