<?php

require_once '../database.php';

class LoginModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MysqlConnection();
    }
    
    public function authenticate($username, $password)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM datos_usuarios WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($register = $result->fetch_assoc()){
            if(password_verify($password, $register['contrasena'])){
                return true;
            } else {
                return false;
            }
        }
        
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
