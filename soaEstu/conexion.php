<?php
class Conexion {
    private $host = "localhost";
    private $db_name = "basefinal";
    private $username = "root";
    private $password = "";
    private $conn;

    public function conectar() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Error al intentar establecer conexión con la base de datos: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
