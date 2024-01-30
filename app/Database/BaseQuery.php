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
}