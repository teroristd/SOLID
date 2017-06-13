<?php

namespace application\sessions;

use application\interfaces\ISession;

class DBSession implements ISession
{
    public function sessionRun($name, $lifetime, $path, $secure, $dbConnection, $tableName, $domain = null)
    {
        // TODO: Implement sessionRun() method.
    }

    public function setSessionData($name, $value)
    {
        // TODO: Implement setSessionData() method.
    }

    public function getSessionData($name)
    {
        // TODO: Implement getSessionData() method.
    }

    public function getSessionId()
    {
        // TODO: Implement getSessionId() method.
    }

    public function saveSession()
    {
        // TODO: Implement saveSession() method.
    }

    public function destroySession()
    {
        // TODO: Implement destroySession() method.
    }
}