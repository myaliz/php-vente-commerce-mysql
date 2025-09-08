<?php
namespace App\Models;

class Message extends Model {

    public function saveMessage($name, $phone, $email, $message) {
        $stmt = $this->db->prepare("INSERT INTO message (name, phone, email, message) VALUES (:name, :phone, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }
}