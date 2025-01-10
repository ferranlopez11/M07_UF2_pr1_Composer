<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct() {
        // Leer configuración desde el archivo ini
        $config = parse_ini_file(__DIR__ . '/../../config/db_config.ini');

        $this->host = $config['host'] ?? 'localhost';
        $this->username = $config['username'] ?? 'root';
        $this->password = $config['password'] ?? '';
        $this->dbname = $config['dbname'] ?? 'Workshop';
    }

    public function connect() {
        if ($this->connection === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
                $this->connection = new PDO($dsn, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return $this->connection;
    }
}
