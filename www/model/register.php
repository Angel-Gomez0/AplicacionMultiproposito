<?php
require_once '../database.php';

class RegisterModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MysqlConnection();
    }

  public function registerUser($username, $email, $password, $id_gender) {
    $conn = $this->db->getConnection();
    
    try {
        $checkStmt = $conn->prepare("SELECT id FROM datos_usuarios WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
        
        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            return ["success" => false, "message" => "El email ya está registrado"];
        }
        $checkStmt->close();

        $stmt = $conn->prepare("INSERT INTO datos_usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            
            $id_rol = 2;
            $status = 'Registrado';
            
            $stmt2 = $conn->prepare("INSERT INTO usuarios (id_dato_user, estado, id_rol, id_genero) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("isii", $id, $status, $id_rol, $id_gender);
            
            if ($stmt2->execute()) {
                $stmt2->close();
                return ["success" => true, "id" => $id];
            } else {
                throw new Exception("Error al insertar en usuarios: " . $stmt2->error);
            }
        } else {
            throw new Exception("Error al insertar en datos_usuarios: " . $stmt->error);
        }
        
    } catch (Exception $e) {
        error_log("Error en registerUser: " . $e->getMessage());
        return ["success" => false, "message" => "Error en el registro"];
    }
}

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
