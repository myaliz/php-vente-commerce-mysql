<?php
namespace App\Controllers;

require_once __DIR__.'/../Models/OrderModel.php';
require_once __DIR__.'/../Models/Product.php';
require_once __DIR__.'/../Models/Model.php'; // Ajoutez cette ligne

use App\Models\OrderModel;
use App\Models\Product;
use Exception;

class CartController extends Controller {
    private $productModel;
    protected $db;

     public function __construct() {
       // parent::__construct(); // Appel au constructeur parent
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialisez la connexion DB
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=mon_mvc;charset=utf8', 'root', '');
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Erreur de connexion: " . $e->getMessage());
        }
        
        $this->productModel = new Product();
    }

    // Existing addToCart method (for incremental additions, e.g., from product listings)
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productName = $_POST['product'] ?? null;
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

            if (!$productName || $quantity <= 0) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Nom du produit ou quantité invalide.']);
                exit();
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $product = $this->productModel->getByName($productName);
            if (!$product) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Produit non trouvé.']);
                exit();
            }

            // This is the ADDITIVE logic
            if (isset($_SESSION['cart'][$productName])) {
                $_SESSION['cart'][$productName] += $quantity;
            } else {
                $_SESSION['cart'][$productName] = $quantity;
            }

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier.']);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
        exit();
    }

    // NEW METHOD: For setting (overriding) the quantity in the cart
    public function setProductQuantityInCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productName = $_POST['product'] ?? null;
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

            if (!$productName || $quantity <= 0) {
                // If quantity is 0 or less, remove the item from the cart
                if (isset($_SESSION['cart'][$productName])) {
                    unset($_SESSION['cart'][$productName]);
                }
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Produit supprimé du panier.']);
                exit();
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $product = $this->productModel->getByName($productName);
            if (!$product) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Produit non trouvé.']);
                exit();
            }
            
            // This is the SETTING logic (overrides current quantity)
            $_SESSION['cart'][$productName] = $quantity;

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Quantité du produit mise à jour dans le panier.']);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
        exit();
    }

    // showCart method (you already have this)
    public function showCart() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $cartDetails = [];
        $totalPrice = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $productName => $quantity) {
                $product = $this->productModel->getByName($productName);
                if ($product) {
                    $itemTotal = $product['price'] * $quantity;
                    $cartDetails[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'total' => $itemTotal
                    ];
                    $totalPrice += $itemTotal;
                } else {
                    // Product not found in DB, remove from cart
                    unset($_SESSION['cart'][$productName]);
                }
            }
        }
        $this->render('cart', ['cartDetails' => $cartDetails, 'totalPrice' => $totalPrice]);
    }

    // updateCartQuantity method (you already have this)
    public function updateCartQuantity() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product']) && isset($_POST['newQuantity'])) {
            $productName = $_POST['product'];
            $newQuantity = intval($_POST['newQuantity']);

            if (isset($_SESSION['cart'][$productName])) {
                if ($newQuantity > 0) {
                    $_SESSION['cart'][$productName] = $newQuantity;
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Quantité mise à jour.']);
                    exit();
                } else {
                    unset($_SESSION['cart'][$productName]);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Produit supprimé du panier.']);
                    exit();
                }
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Produit non trouvé dans le panier.']);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
        exit();
    }

    // removeFromCart method (you already have this)
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productToRemove'])) {
            $productToRemove = $_POST['productToRemove'];
            if (isset($_SESSION['cart'][$productToRemove])) {
                unset($_SESSION['cart'][$productToRemove]);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Article supprimé du panier.']);
                exit();
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Article non trouvé dans le panier.']);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
        exit();
    }

    // clearCart method (you already have this)
    public function clearCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
            unset($_SESSION['cart']);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Panier vidé avec succès.']);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
        exit();
    }

    // validatePurchase method (you already have this)
    public function validatePurchase() {
        // Implement your purchase validation logic here
        // e.g., move items from cart to an orders table, clear cart
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate'])) {
            if (!empty($_SESSION['cart'])) {
                // Example: Log purchase (in a real app, this would involve database transactions)
                // file_put_contents('purchases.log', date('Y-m-d H:i:s') . ': ' . json_encode($_SESSION['cart']) . "\n", FILE_APPEND);

                // Clear the cart after "purchase"
                unset($_SESSION['cart']);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Achat validé avec succès !']);
                exit();
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Votre panier est vide.']);
            exit();
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
        exit();
    }

 public function showCheckoutConfirmation() {
    // Vérifier que le panier existe
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header('Location: index.php?action=showCart');
        exit();
    }

    // Calculer le total
    $totalPrice = 0;
    $cartDetails = [];
    $productModel = new Product();
    
    foreach ($_SESSION['cart'] as $productName => $quantity) {
        $product = $productModel->getByName($productName);
        if ($product) {
            $itemTotal = $product['price'] * $quantity;
            $cartDetails[] = [
                'product' => $product,
                'quantity' => $quantity,
                'total' => $itemTotal
            ];
            $totalPrice += $itemTotal;
        }
    }

    // Stocker les données de commande en session
    $_SESSION['order_details'] = [
        'cart_items' => $_SESSION['cart'],
        'total_price' => $totalPrice,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $this->render('checkout_confirmation', [
        'cartDetails' => $cartDetails,
        'totalPrice' => $totalPrice
    ]);
}

  

    
public function finalizePurchase() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
        if (!empty($_SESSION['cart'])) {
            // Récupération des données du formulaire
            $customerInfo = [
                'nom' => $_POST['nom'] ?? '',
                'prenom' => $_POST['prenom'] ?? '',
                'email' => $_POST['email'] ?? '',
                'adresse' => $_POST['adresse'] ?? '',
                'telephone' => $_POST['telephone'] ?? ''
            ];

            // Calcul du total et préparation des items
            $totalPrice = 0;
            $productModel = new Product();
            $cartDetails = [];
            
            foreach ($_SESSION['cart'] as $productName => $quantity) {
                $product = $productModel->getByName($productName);
                if ($product) {
                    $itemTotal = $product['price'] * $quantity;
                    $cartDetails[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'total' => $itemTotal
                    ];
                    $totalPrice += $itemTotal;
                }
            }

            // Insertion dans la base de données
            $orderModel = new OrderModel();
            
            try {
                // Commencer une transaction
                $this->db->beginTransaction();
                
                // Créer la commande
                $orderId = $orderModel->createOrder($customerInfo, $totalPrice);
                
                // Ajouter les items de la commande
                $orderModel->addOrderItems($orderId, $cartDetails);
                
                // Valider la transaction
                $this->db->commit();
                
                // Stocker les infos en session
                $_SESSION['order_details'] = [
                    'order_id' => $orderId,
                    'cart_items' => $_SESSION['cart'],
                    'total_price' => $totalPrice,
                    'customer_info' => $customerInfo,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                // Vider le panier
                unset($_SESSION['cart']);
                
                // Redirection vers la page de paiement
                header('Location: index.php?action=showPaymentPage');
                exit();
                
            } catch (Exception $e) {
                // Annuler la transaction en cas d'erreur
                $this->db->rollBack();
                error_log("Erreur lors de la création de la commande: " . $e->getMessage());
                
                // Afficher un message d'erreur
                $_SESSION['error_message'] = "Une erreur est survenue lors du traitement de votre commande. Veuillez réessayer.";
                header('Location: index.php?action=showCart');
                exit();
            }
        } else {
            // Gérer le cas où le panier est vide
            header('Location: index.php?action=showCart');
            exit();
        }
    }
    // Si la requête n'est pas POST ou manque des données
    header('Location: index.php?action=showCart');
    exit();



    
}

   




public function refreshCartData() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refresh'])) {
        // Recalculer le panier
        $productModel = new Product();
        $cart = $_SESSION['cart'] ?? [];
        $updatedCart = [];
        
        foreach ($cart as $productName => $quantity) {
            $product = $productModel->getByName($productName);
            if ($product) {
                $updatedCart[$productName] = $quantity;
            }
        }
        
        $_SESSION['cart'] = $updatedCart;
        echo json_encode(['success' => true]);
        exit();
    }
}
}