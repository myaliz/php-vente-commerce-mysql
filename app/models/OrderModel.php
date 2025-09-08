<?php
namespace App\Models;

class OrderModel extends Model {
    
    public function createOrder($customerInfo, $totalAmount) {
        $sql = "INSERT INTO orders (customer_name, customer_firstname, customer_email, customer_address, customer_phone, total_amount, order_date, status) 
                VALUES (:name, :firstname, :email, :address, :phone, :total_amount, NOW(), 'pending')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $customerInfo['nom'],
            ':firstname' => $customerInfo['prenom'],
            ':email' => $customerInfo['email'],
            ':address' => $customerInfo['adresse'],
            ':phone' => $customerInfo['telephone'],
            ':total_amount' => $totalAmount
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function addOrderItems($orderId, $items) {
        $sql = "INSERT INTO order_items (order_id, product_name, quantity, unit_price, item_total) 
                VALUES (:order_id, :product_name, :quantity, :unit_price, :item_total)";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($items as $item) {
            $stmt->execute([
                ':order_id' => $orderId,
                ':product_name' => $item['product']['name'],
                ':quantity' => $item['quantity'],
                ':unit_price' => $item['product']['price'],
                ':item_total' => $item['total']
            ]);
        }
    }
}