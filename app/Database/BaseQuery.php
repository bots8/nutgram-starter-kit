<?php

namespace App\Database;

use App\Database\BaseConnection;

/**
 * Base query builder
 */
class BaseQuery extends BaseConnection
{
    protected $table;
    protected $columns = [];
    protected $conditions = [];
    protected $ordering = [];
    protected $limit;

    /**
     * Set the table for the query.
     * 
     * @param string $table The name of the table.
     * @return $this The current instance for method chaining.
     */
    public function table($table) {
        $this->table = $table;
        return $this;
    }

    /**
     * Set the columns to be selected.
     * 
     * @param mixed $columns Either an array of columns or a variable-length list of columns.
     * @return $this The current instance for method chaining.
     */
    public function select($columns) {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Add a WHERE condition to the query.
     * 
     * @param string $column The column name.
     * @param string $operator The comparison operator.
     * @param mixed $value The value to compare against.
     * @return $this The current instance for method chaining.
     */
    public function where($column, $operator, $value) {
        $this->conditions[] = "$column $operator '$value'";
        $this->bindParams[":$column"] = $value;
        return $this;
    }

    /**
     * Set the limit for the query.
     * 
     * @param int $number The limit number.
     * @return $this The current instance for method chaining.
     */
    public function limit($number)
    {
        $this->limit = $number;
        return $this;
    }

    /**
     * Set the ordering for the query.
     * 
     * @param string $column The column to order by.
     * @param string $type The type of ordering (ASC or DESC).
     * @return $this The current instance for method chaining.
     */
    public function orderBy($column, $type = "ASC")
    {
        $this->ordering = [$column, $type];
        return $this;
    }
}
