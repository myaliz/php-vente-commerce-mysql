<?php
namespace App\Models;

use PDO;
use PDOException;
require_once 'Model.php';

class Product extends Model {
    protected $table = 'products'; // This is correct, your table is 'products'

    public function getAll() {
        $sql = "SELECT id, name, price, image, description, qtt FROM products";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

 public function getById($id) {
    try {
        $sql = "SELECT p.*, pp.taille, pp.couleur, pp.description_generale 
                FROM products p
                LEFT JOIN publicite_produit pp ON p.id = pp.id_produit
                WHERE p.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Erreur dans getById: " . $e->getMessage());
        return false;
    }
}
 
    public function insert($name, $price, $imagePath, $description, $qtt) {
        try {
            $sql = "INSERT INTO products (name, price, image, description, qtt) VALUES (:name, :price, :image, :description, :qtt)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':qtt', $qtt, PDO::PARAM_INT);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
               error_log("Erreur lors de l'ajout du produit : " . $e->getMessage());
            return false;
        }
    }

    public function getByName($name) {
        $sql = "SELECT id, name, price, image, description, qtt FROM products WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $price, $imagePath, $description, $qtt) {
            try {
                $sql = "UPDATE products SET name = :name, price = :price, description = :description, qtt = :qtt";
                $params = [
                    ':name' => $name,
                    ':price' => $price,
                    ':description' => $description,
                    ':qtt' => $qtt,
                ];

                if ($imagePath !== null && $imagePath !== '') {
                    $sql .= ", image = :image";
                    $params[':image'] = $imagePath;
                }
                $sql .= " WHERE id = :id";
                $params[':id'] = $id; 

                $stmt = $this->db->prepare($sql);
                return $stmt->execute($params);
            } catch (PDOException $e) {
                error_log("Erreur lors de la modification du produit (ID: $id) : " . $e->getMessage());
                return false;
            }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du produit (ID: $id): " . $e->getMessage());
            return false;
        }
    }

   
  
    public function getProductPubliciteDetails($productId) {
        $query = "SELECT taille, couleur, description_generale FROM publicite_produit WHERE id_produit = :id_produit LIMIT 1";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_produit', $productId, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error fetching product publicite details: " . $e->getMessage());
            return null;
        }
    }

    public function getAllProductPublicite() {
        $sql = "
            SELECT
                pp.id_pub,             -- Added this line to select id_pub
                pp.id_produit,
                p.name AS product_name,
                p.image AS product_image,
                pp.taille,
                pp.couleur,
                pp.description_generale
            FROM
                publicite_produit pp
            JOIN
                products p ON pp.id_produit = p.id
            ORDER BY
                pp.id_produit DESC
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}