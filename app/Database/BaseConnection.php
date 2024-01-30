<?php

namespace App\Database;

use PDO;
use PDOException;

/**
 * Database connection
 */
class BaseConnection
{
    protected $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}