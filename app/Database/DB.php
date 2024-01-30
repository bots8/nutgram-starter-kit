<?php

namespace App\Database;

use App\Database\BaseQuery;
use PDO;

/**
 * Database manager
 */
class DB extends BaseQuery
{
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

    public function findByPk($primaryKey, $pkName = 'id') {
        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table WHERE $pkName = $primaryKey";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row ?: [];
    }

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

        return $row['COUNT(id)'] ?: [];
    }

    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        // dd($query);
        $statement = $this->connection->prepare($query);
        $statement->execute($data);

        // Return the last inserted ID
        return $this->connection->lastInsertId();
    }

    public function update($data) {
        $setClause = [];

        foreach ($data as $column => $value) {
            $setClause[] = "$column = '$value'";
        }

        $query = "UPDATE $this->table SET " . implode(", ", $setClause);
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    public function increment($column, $inc = 1) {

        $query = "UPDATE $this->table SET $column = $column + $inc";
        
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

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