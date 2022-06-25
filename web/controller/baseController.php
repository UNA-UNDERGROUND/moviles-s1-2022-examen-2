<?php

$vendor_path = realpath(dirname(__FILE__) . '/../vendor');
$dboilerplate_path = $vendor_path . '/una-ouroboros/DBoilerplate';

require_once $dboilerplate_path . '/MySqlConnectionProvider.sql';


use una_ouroboros\DBoilerplate\MySqlConnectionProvider;


class BaseController extends MySqlConnectionProvider
{
    private string $table;

    function __construct(string $table)
    {
        parent::__construct("examen", "local");
        $this->table = $table;
    }

    // generic exist based on id
    public function exist(int $id): bool
    {
        $rows = $this->select(['id' => $id]);
        return count($rows) > 0;
    }

    // do a generic select based on the provided values
    // example:
    // values = ['username' => 'johndoe', 'password' => '123456']
    // query  = SELECT * FROM table WHERE username = 'johndoe' AND password = '123456'
    // note: if values is empty or null, it will return all rows
    // return an array of the results
    protected function select(array $values)
    {
        // prepare the statement
        $query = "SELECT * FROM " . $this->table;
        // check if values is empty or null
        if (
            $values != null &&
            count($values) > 0
        ) {
            // add WHERE clause
            $query .= " WHERE ";
            // add the values like " username = ? AND password = ? "
            $query .= implode(" AND ", array_map(function ($key) {
                return $key . " = ?";
            }, array_keys($values)));
        }
        // prepare the statement
        $conn = parent::getConnection();
        $stmt = $conn->prepare($query);
        // bind the values
        $stmt->bind_param(str_repeat('s', count($values)), ...array_values($values));
        // execute the statement
        $stmt->execute();
        // get the results
        $result = $stmt->get_result();
        // fetch the results
        $results = $result->fetch_all(MYSQLI_ASSOC);
        // close the statement
        $stmt->close();
        // close the connection
        $conn->close();
        // return the results
        return $results;
    }

    // do a generic insert based on the provided values
    // example:
    // values = ['username' => 'johndoe', 'password' => '123456']
    // query  = INSERT INTO table (username, password) VALUES ('johndoe', '123456')
    // return the id of the inserted row or false if an error occurred
    protected function insert(array $values)
    {
        // prepare the statement
        $query = "INSERT INTO " . $this->table . " (" . implode(", ", array_keys($values)) . ") VALUES (" . implode(", ", array_map(function () {
            return "?";
        }, array_values($values))) . ")";
        // prepare the statement
        $conn = parent::getConnection();
        $stmt = $conn->prepare($query);
        // bind the values
        $stmt->bind_param(str_repeat('s', count($values)), ...array_values($values));
        // execute the statement
        $stmt->execute();
        // get the id of the inserted row
        $id = $stmt->insert_id;
        // close the statement
        $stmt->close();
        // close the connection
        $conn->close();
        // return the id or false if an error occurred
        return $id;
    }

    // do a generic update based on the provided values
    // example:
    // values = ['username' => 'johndoe', 'password' => '123456']
    // query  = UPDATE table SET username = 'johndoe', password = '123456' WHERE id = 1
    // return true if the update was successful or false if an error occurred
    protected function update(array $values, int $id)
    {
        // prepare the statement
        $query = "UPDATE " . $this->table . " SET " . implode(", ", array_map(function ($key) {
            return $key . " = ?";
        }, array_keys($values))) . " WHERE id = ?";
        // prepare the statement
        $conn = parent::getConnection();
        $stmt = $conn->prepare($query);
        // bind the values (iteratively)
        foreach ($values as $value) {
            $stmt->bind_param('s', $value);
        }
        // bind the id
        $stmt->bind_param('i', $id);
        // execute the statement
        $stmt->execute();
        // close the statement
        $stmt->close();
        // close the connection
        $conn->close();
        // return true if the update was successful or false if an error occurred
        return $stmt->affected_rows > 0;
    }

    // do a generic delete based on the provided id
    // example:
    // id = 1
    // query  = DELETE FROM table WHERE id = 1
    // return true if the delete was successful or false if an error occurred
    protected function delete(int $id)
    {
        // prepare the statement
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        // prepare the statement
        $conn = parent::getConnection();
        $stmt = $conn->prepare($query);
        // bind the values
        $stmt->bind_param('i', $id);
        // execute the statement
        $stmt->execute();
        // close the statement
        $stmt->close();
        // close the connection
        $conn->close();
        // return true if the delete was successful or false if an error occurred
        return $stmt->affected_rows > 0;
    }
}
