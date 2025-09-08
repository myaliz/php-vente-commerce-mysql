<?php
namespace App\Models;

use PDO;
use PDOException;

require_once 'Model.php';

class PubliciteProduit extends Model {

    protected $table = 'publicite_produit';

    /**
     * Delete a publicite product entry by its ID (id_pub).
     *
     * @param int $id_pub The ID of the publicite product to delete.
     * @return bool True on success, false on failure.
     */
    public function deletePubliciteProduct($id_pub) {
        try {
            $sql = "DELETE FROM publicite_produit WHERE id_pub = :id_pub";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_pub', $id_pub, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la publicité (ID Pub: $id_pub): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get a single publicite product entry by its ID (id_pub).
     * This might be useful if you later choose a modal for editing instead of full inline.
     *
     * @param int $id_pub The ID of the publicite product to retrieve.
     * @return array|false An associative array of the publicite product data, or false if not found.
     */
    public function getPubliciteProductByIdPub($id_pub) {
        $sql = "
            SELECT
                pp.id_pub,
                pp.id_produit,
                pp.taille,
                pp.couleur,
                pp.description_generale,
                p.name AS product_name,
                p.image AS product_image
            FROM
                publicite_produit pp
            JOIN
                products p ON pp.id_produit = p.id
            WHERE
                pp.id_pub = :id_pub
        ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_pub', $id_pub, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la publicité (ID Pub: $id_pub): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update a publicite product entry.
     *
     * @param int $id_pub The ID of the publicite product to update.
     * @param string $taille The new size.
     * @param string $couleur The new color.
     * @param string $description_generale The new general description.
     * @return bool True on success, false on failure.
     */
    public function updatePubliciteProduct($id_pub, $taille, $couleur, $description_generale) {
        $sql = "
            UPDATE publicite_produit
            SET
                taille = :taille,
                couleur = :couleur,
                description_generale = :description_generale
            WHERE
                id_pub = :id_pub
        ";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':taille', $taille, PDO::PARAM_STR);
            $stmt->bindParam(':couleur', $couleur, PDO::PARAM_STR);
            $stmt->bindParam(':description_generale', $description_generale, PDO::PARAM_STR);
            $stmt->bindParam(':id_pub', $id_pub, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de la publicité (ID Pub: $id_pub): " . $e->getMessage());
            return false;
        }
    }












   public function getPublicitesByProductId($productId) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE product_id = :product_id ORDER BY date DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching publicites for product ID {$productId}: " . $e->getMessage());
            return [];
        }
    }



















}