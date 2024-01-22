<?php

namespace App;

class QueryBuilder {

    private $table;
    private $columns = [];
    private $conditions = [];
    private $connection;

    public function __construct()
    {
    	$this->connection = mysqli_connect(
    		$_ENV['DB_HOST'], 
    		$_ENV['DB_USERNAME'], 
    		$_ENV['DB_PASSWORD'], 
    		$_ENV['DB_NAME']
    	);
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
        return $this;
    }

    public function findAll() {
        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table";

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $result = $this->connection->query($query);

        if ($result) {
	        // Fetch all rows as an associative array
	        $rows = $result->fetch_all(MYSQLI_ASSOC);

	        return $rows;
	    } else {
	        // If the query fails, return an empty array
	        return [];
	    }
    }

    public function findByPk($primaryKey) {
    	if(empty($this->columns)) {
    		$this->columns = ['*'];
    	}

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table WHERE id = '$primaryKey'";
        
        $result = $this->connection->query($query);

        if ($result) {
	        // Fetch as an associative array
	        $rows = $result->fetch_assoc();

	        return $rows;
	    } else {
	        // If the query fails, return an empty array
	        return [];
	    }
    }

    public function first() {
    	if(empty($this->columns)) {
    		$this->columns = ['*'];
    	}

        $query = "SELECT " . implode(", ", $this->columns) . " FROM $this->table";

        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }
        
        $result = $this->connection->query($query);

        if ($result) {
	        // Fetch as an associative array
	        $rows = $result->fetch_assoc();

	        return $rows;
	    } else {
	        // If the query fails, return an empty array
	        return [];
	    }
    }

    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        
        $result = $this->connection->query($query);

        if ($result) {
        	// Return the last inserted ID
	        $lastId = mysqli_insert_id($this->connection);
	        return $lastId;
	    } else {
	        // If the query fails, return false
	        return false;
	    }
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
        
        $result = $this->connection->query($query);

        return $result > 0;
    }

    public function delete() {
        $query = "DELETE FROM $this->table";
        if (!empty($this->conditions)) {
            $query .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $result = $this->connection->query($query);

        return $result > 0;
    }
}