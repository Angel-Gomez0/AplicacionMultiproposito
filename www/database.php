<?php
class MysqlConnection {
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    public $connection;

    public function __construct() {
        $this->host = 'aplicacionMultiproposito-mysql';  
        $this->port = 3306;
        $this->user = 'root';
        $this->password = 'root'; 
        $this->database = 'aplicacionMultiproposito';
        
        $this->connect();
    }

    private function connect() {
        try {
            // Conexión con MySQLi
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
            // Verificar errores de conexión
            if ($this->connection->connect_error) {
                throw new Exception("Error de conexión MySQLi: " . $this->connection->connect_error);
            }
            
            // Establecer el charset
            $this->connection->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>