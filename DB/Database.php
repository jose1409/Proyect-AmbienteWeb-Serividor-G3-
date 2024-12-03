<?php

class Database {
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    private $connection;

    public function __construct($host = "localhost", $user = "root", $password = "", $database = "registro_academico", $port = 3307) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;

        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

        if ($this->connection->connect_error) {
            die("Error en la conexión: " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);

        if ($this->connection->error) {
            die("Error en la consulta: " . $this->connection->error);
        }

        return $result;
    }

    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }

    public function getLastInsertId() {
        return $this->connection->insert_id;
    }

    public function close() {
        $this->connection->close();
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
