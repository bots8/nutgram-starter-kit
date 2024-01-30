<?php

namespace App\Database;

use App\Database\BaseQuery;
use PDO;

/**
 * Database manager
 */
class DB extends BaseQuery
{
    /**
     * Retrieve all records from the table based on the conditions.
     *
     * @return array An array of records fetched from the database.
     */
    public function findAll() {
        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table";

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(' AND ', $this->conditions);
        }

        if(!empty($this->ordering)) {
            $query .= " ORDER BY {$this->ordering[0]} {$this->ordering[1]}";
        }

        if(!empty($this->limit)) {
            $query .= " LIMIT {$this->limit}";
        }
        
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    /**
     * Find a record by its primary key.
     *
     * @param mixed $primaryKey The value of the primary key.
     * @param string $pkName The name of the primary key column.
     * @return array The fetched record.
     */
    public function findByPk($primaryKey, $pkName = 'id') {
        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table WHERE $pkName = :primaryKey";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(':primaryKey', $primaryKey, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }

    /**
     * Retrieve the first record from the table based on the conditions.
     *
     * @return array The first record fetched from the database.
     */
    public function first() {
        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table";

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }

    /**
     * Count the number of records in the table based on the conditions.
     *
     * @return int The number of records.
     */
    public function count() {
        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $query = "SELECT COUNT(id) FROM $this->table";

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['COUNT(id)'] ?: 0;
    }

    /**
     * Insert a new record into the table.
     *
     * @param array $data The data to be inserted.
     * @return int The last inserted ID.
     */
    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($query);
        $statement->execute($data);

        return $this->connection->lastInsertId();
    }

    /**
     * Update records in the table.
     *
     * @param array $data The data to be updated.
     * @return bool True if the update is successful, false otherwise.
     */
    public function update($data) {
        $setClause = [];

        foreach ($data as $column => $value) {
            $setClause[] = "$column = :$column";
        }

        $query = "UPDATE $this->table SET " . implode(", ", $setClause);
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute($data);

        return $statement->rowCount() > 0;
    }

    /**
     * Increment a column value in the table.
     *
     * @param string $column The column to be incremented.
     * @param int $inc The value to increment by (default is 1).
     * @return bool True if the increment is successful, false otherwise.
     */
    public function increment($column, $inc = 1) {

        $query = "UPDATE $this->table SET $column = $column + :inc";
        
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->bindParam(':inc', $inc, PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    /**
     * Delete records from the table.
     *
     * @return bool True if records are deleted, false otherwise.
     */
    public function delete() {
        $query = "DELETE FROM $this->table";
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->rowCount() > 0;
    }
}
