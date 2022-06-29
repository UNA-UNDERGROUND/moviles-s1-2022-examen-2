<?php

namespace una_ouroboros\DBoilerplate;

$path_dboilerplate = realpath(dirname(__FILE__)).'/';
require_once $path_dboilerplate. 'DBCredentialProvider.php';


class MySqlConnectionProvider extends DBCredentialProvider
{
    // constructor
    function __construct($app, $database)
    {
        parent::__construct($app, $database);
    }

    protected function getConnection()
    {
        $conn = new \mysqli($this->host, $this->user, $this->pass, $this->base);
        $conn->set_charset('utf8');
        return $conn;
    }

    protected function query($sql, $params = array())
    {
        $result = $this->executeQuery($sql, $params);
        if ($result) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    protected function executeQuery($sql, $params = array())
    {
        $result = $this->execute($sql, $params);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    protected function execute($sql, $params = array())
    {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return false;
        }
    }
}
