<?php 

require_once '../database.php';

class Genders {
    public function getGenders() {
        $db = new MysqlConnection();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM generos");
        $stmt->execute();
        $result = $stmt->get_result();
        $genders = [];
        while ($row = $result->fetch_assoc()) {
            $genders[] = $row;
        }
        $db->closeConnection();
        return $genders;
    }
}