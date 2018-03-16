<?php

namespace application;

class Database
{
    private $_connection;
    private $_db;
    private $_stmt;
    private $_params;
    private $_sql;

    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;

        $this->_db = $this->_connection->getConnection();
    }

    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->_stmt = $this->_db->prepare($sql, $pdoOptions);

        $this->_params = $params;

        $this->_sql = $sql;

        return $this;
    }

    public function execute($params = array())
    {
        if ($params)
        {
            $this->_params = $params;
        }

        $this->_stmt->execute($this->_params);

        return $this;
    }

    public function fetchAllAssoc()
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function fetchRowAssoc()
    {
        return $this->_stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function fetchAllNum()
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_NUM);
    }


    public function fetchRowNum()
    {
        return $this->_stmt->fetch(\PDO::FETCH_NUM);
    }


    public function fetchAllObj()
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public function fetchRowObj()
    {
        return $this->_stmt->fetch(\PDO::FETCH_OBJ);
    }


    public function fetchAllColumn($column)
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_COLUMN, $column);
    }


    public function fetchRowColumn($column)
    {
        return $this->_stmt->fetch(\PDO::FETCH_BOUND, $column);
    }


    public function fetchAllClass($class)
    {
        return $this->_stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }


    public function fetchRowClass($class)
    {
        return $this->_stmt->fetch(\PDO::FETCH_BOUND, $class);
    }


    public function getLastInsertId()
    {
        return $this->_db->lastInsertId();
    }


    public function getAffectedRows()
    {
        return $this->_stmt->rowCount();
    }


    public function getSTMT()
    {
        return $this->_stmt;
    }
}