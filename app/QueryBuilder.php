<?php

namespace App;

class QueryBuilder {

    private $table;
    private $columns = [];
    private $conditions = [];
    private $ordering = [];
    private $limit;
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new \PDO(
                "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }

    public function select($columns) {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function where($column, $operator, $value) {
        $this->conditions[] = "$column $operator '$value'";
        $this->bindParams[":$column"] = $value;
        return $this;
    }

    public function limit($number)
    {
        $this->limit = $number;
        return $this;
    }

    public function orderBy($column, $type = "ASC")
    {
        $this->ordering = [$column, $type];
        return $this;
    }

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
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $rows;
    }

    public function findByPk($primaryKey) {
        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table WHERE id = $primaryKey";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

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
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        return $row ?: [];
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
