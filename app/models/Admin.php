<?php
namespace App\Models;

use PDO;

class Admin extends Model {

    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


     public function getAllMessages() {
        $stmt = $this->db->query("SELECT * FROM message ORDER BY id DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


     public function deleteMessage($id) {
        $stmt = $this->db->prepare("DELETE FROM message WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}