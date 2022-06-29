<?php

$vendor_path = realpath(dirname(__FILE__) . '/../vendor');
$dboilerplate_path = $vendor_path . '/una-ouroboros/DBoilerplate';

require_once $dboilerplate_path . '/MySqlConnectionProvider.php';


use una_ouroboros\DBoilerplate\MySqlConnectionProvider;


class BaseController extends MySqlConnectionProvider
{
    private string $table;

    function __construct(string $table)
    {
        parent::__construct("examen", "local");
        $this->table = $table;
        $this->throwIfTableDoesNotExist();
    }

    private function throwIfTableDoesNotExist(): void
    {
        $conn = null;
        try {
            $sql = "SELECT * FROM $this->table";
            $conn = parent::getConnection();
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                // get the error of the statement
                $error = $conn->error;
                // check if was caused by a table not existing
                if (strpos($error, "doesn't exist") !== false) {
                    throw new Exception("Table $this->table does not exist", 404);
                } else {
                    throw new Exception("Error while preparing statement: $error", 500);
                }
            }
            // close the statement
            $stmt->close();
        } catch (Throwable $e) {
            // check if the exception was caused due to the table not existing
            if ($e->getCode() == 1146) {
                throw new Exception("Table $this->table does not exist");
            }
        } finally {
            if ($conn != null) {
                $conn->close();
            }
        }
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
        $conn = null;
        $stmt = null;
        try {
            $with_values = $values != null &&
                count($values) > 0;
            // prepare the statement
            $query = "SELECT * FROM " . $this->table;
            // check if values is empty or null
            if ($with_values) {
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
            if (!$stmt) {
                // get the error of the statement
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            // bind the values
            if ($with_values) {
                $stmt->bind_param(
                    str_repeat(
                        's',
                        count($values)
                    ),
                    ...array_values($values)
                );
            }
            // execute the statement
            $stmt->execute();
            // get the results
            $result = $stmt->get_result();
            // fetch the results
            $results = $result->fetch_all(MYSQLI_ASSOC);

            return $results;
        } catch (\Throwable $th) {
            // rethrow with this function name
            throw new Exception(
                "Error in " . __FUNCTION__ . ": " . $th->getMessage(),
                $th->getCode(),
                $th
            );
            //throw $th;
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
            if ($conn != null) {
                $conn->close();
            }
        }
    }

    // do a generic insert based on the provided values
    // example:
    // values = ['username' => 'johndoe', 'password' => '123456']
    // query  = INSERT INTO table (username, password) VALUES ('johndoe', '123456')
    // return the id of the inserted row or false if an error occurred
    protected function insert(array $values)
    {
        $conn = null;
        try {
            // prepare the statement
            $query = "INSERT INTO " . $this->table . " (" . implode(", ", array_keys($values)) . ") VALUES (" . implode(", ", array_map(function () {
                return "?";
            }, array_values($values))) . ")";
            // prepare the statement
            $conn = parent::getConnection();
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                // get the error of the statement
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            // bind the values
            $stmt->bind_param(str_repeat('s', count($values)), ...array_values($values));
            // execute the statement
            $stmt->execute();
            // get the id of the inserted row
            $id = $stmt->insert_id;
            // close the statement
            $stmt->close();
            // return the id or false if an error occurred
            return $id;
        } catch (Throwable $e) {
            // check if the exception was caused due to a duplicate entry
            if ($e->getCode() == 1062) {
                throw new Exception("Duplicate entry", 409);
            }
            // check if was caused due to a failing foreign key constraint
            if ($e->getCode() == 1452) {
                throw new Exception("required reference id not found", 409);
            } else {
                throw $e;
            }
        } finally {
            if ($conn != null) {
                $conn->close();
            }
        }
    }

    // do a generic update based on the provided values
    // example:
    // values = ['username' => 'johndoe', 'password' => '123456']
    // query  = UPDATE table SET username = 'johndoe', password = '123456' WHERE id = 1
    // return true if the update was successful or false if an error occurred
    protected function update(array $values, int $id)
    {
        $conn = null;
        $stmt = null;
        try {
            // check if exist
            if (!$this->exist($id)) {
                throw new Exception("Not found", 404);
            }

            // prepare the statement
            $query = "UPDATE " . $this->table . " SET ";
            // add all the values except the id
            foreach (array_keys($values) as $key) {
                if ($key != 'id') {
                    $query .= $key . " = ?, ";
                }
            }
            // remove the last comma
            $query = substr($query, 0, -2);
            // add the WHERE clause
            $query .= " WHERE id = ?";
            // prepare the statement
            $conn = parent::getConnection();
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                // get the error of the statement
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            // set all the values witout the id
            $params = [];
            foreach ($values as $key => $value) {
                if ($key != 'id') {
                    $params[] = $value;
                }
            }
            // put the id at the end of the params
            $params[] = $id;
            // bind the values
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);

            // execute the statement
            $stmt->execute();
            // get the number of rows affected
            $affected_rows = $stmt->affected_rows;
            // return true if the update was successful or false if an error occurred
            return $affected_rows > 0;
        } catch (Throwable $e) {
            // retrow with this function name
            throw new Exception(
                "Error in " . __FUNCTION__ . ": " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
            if ($conn != null) {
                $conn->close();
            }
        }
    }

    // do a generic delete based on the provided id
    // example:
    // id = 1
    // query  = DELETE FROM table WHERE id = 1
    // return true if the delete was successful or false if an error occurred
    protected function delete(int $id)
    {
        $conn = null;
        $stmt = null;
        try {
            // prepare the statement
            $query = "DELETE FROM " . $this->table . " WHERE id = ?";
            // prepare the statement
            $conn = parent::getConnection();
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                // get the error of the statement
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            // bind the values
            $stmt->bind_param('i', $id);
            // execute the statement
            $stmt->execute();
            // get the number of rows affected
            $affected_rows = $stmt->affected_rows;
            // return true if the delete was successful or false if an error occurred
            return $affected_rows > 0;
        } catch (Throwable $e) {
            // retrow with this function name
            throw new Exception(
                "Error in " . __FUNCTION__ . ": " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        } finally {
            if ($stmt != null) {
                $stmt->close();
            }
            if ($conn != null) {
                $conn->close();
            }
        }
    }
}
