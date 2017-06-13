<?php

namespace application\interfaces;

interface ISession
{
    public function sessionRun($name, $lifetime, $path, $secure, $dbConnection, $tableName, $domain);

    public function setSessionData($name, $value);

    public function getSessionData($name);

    public function getSessionId();

    public function saveSession();

    public function destroySession();
}