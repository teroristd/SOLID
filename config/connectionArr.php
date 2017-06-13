<?php

return array (
    'session' => array (
        'host_and_dbName' => 'mysql:host=localhost;dbname=session',
        'username' => '',
        'password' => '',
        'pdo_options' => array (PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    )
);