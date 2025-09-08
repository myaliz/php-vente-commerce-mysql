<?php
namespace App\Controllers;

require_once 'Controller.php';
require_once __DIR__ . '/../models/Product.php';

use App\Models\Product;

class ProductController extends Controller {

    // Vérification de la session avant d'appeler session_start()
    private function startSessionIfNeeded() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showAds() {
        $productModel = new Product();
        $products = $productModel->getAll(); // Récupérer tous les produits

        $this->render('products', ['products' => $products]); // Passer les produits à la vue
    }

    
    


      // Nouvelle méthode pour récupérer l'instance du modèle
    public function getProductModel() {
        return new Product();
    }





    public function showProductDetail()
     {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=showAds');
            exit();
        }

        $productId = (int)$_GET['id'];
        $productModel = $this->getProductModel();
        
        try {
            $product = $productModel->getById($productId);
            
            if (!$product) {
                throw new \Exception("Produit non trouvé");
            }
            
            $additionalDetails = $productModel->getProductPubliciteDetails($productId);
            if ($additionalDetails) {
                $product = array_merge($product, $additionalDetails);
            }
            
            $this->render('product_detail', ['product' => $product]);
            
        } catch (\Exception $e) {
            error_log("Erreur dans showProductDetail: " . $e->getMessage());
            header('Location: index.php?action=showAds');
            exit();
        }
    }
}
    
