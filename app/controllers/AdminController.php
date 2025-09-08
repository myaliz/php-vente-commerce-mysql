<?php
namespace App\Controllers;

require_once 'Controller.php';
require_once __DIR__ . '/../models/Admin.php';
require_once 'ProductController.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/PubliciteProduit.php'; // <<< ADD THIS LINE

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Admin;
use App\Models\Product;
use App\Models\PubliciteProduit; // <<< ADD THIS LINE

class AdminController extends Controller {
    private $adminModel;
    private $productController;
    private $productModel;
    private $publiciteProduitModel; // <<< DECLARE THIS PROPERTY

    public function __construct() {
        $this->adminModel = new Admin();
        $this->productController = new ProductController();
        $this->productModel = new Product();
        $this->publiciteProduitModel = new PubliciteProduit(); // <<< INITIALIZE THIS PROPERTY
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->adminModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // session_start(); // Session is already started in index.php, no need to start again
                $_SESSION['admin_id'] = $user['id_admin'];
                header('Location: index.php?action=adminDashboard');
                exit();
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
                $this->render('login_admin', ['error' => $error]);
            }
        } else {
            $this->render('login_admin');
        }
    }

    public function dashboard() {
        if (isset($_SESSION['admin_id'])) {
            $productModel = $this->productController->getProductModel();
            $products = $productModel->getAll();
            $this->render('admin/dashboard', ['products' => $products, 'current_action' => 'adminDashboard']);
        } else {
            header('Location: index.php?action=adminLogin');
            exit();
        }
    }

    public function showMessengerMessages() {
        $messages = $this->adminModel->getAllMessages();
        $this->render('admin/dashboard', ['messages' => $messages, 'current_action' => 'showMessengerMessages']);
    }

    public function logout() {
        // session_start(); // Session is already started in index.php
        session_destroy();
        header('Location: index.php?action=adminLogin');
        exit();
    }

    public function deleteProduct() {
        // Changed to use $_GET based on dashboard link structure
        if (isset($_GET['id'])) {
            $productId = htmlspecialchars($_GET['id']);
            $productModel = $this->productController->getProductModel();
            $success = $productModel->delete($productId);

            if ($success) {
                header('Location: index.php?action=adminDashboard&success=product_deleted');
                exit();
            } else {
                header('Location: index.php?action=adminDashboard&error=delete_failed');
                exit();
            }
        } else {
            header('Location: index.php?action=adminDashboard&error=invalid_request');
            exit();
        }
    }

    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productId = $_POST['id'];
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0.00;
            $description = $_POST['description'] ?? '';
            $qtt = $_POST['qtt'] ?? 0;
            $imagePath = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../public/images/';
                $uniqueName = uniqid() . '_' . basename($_FILES['image']['name']);
                $imagePath = $uploadDir . $uniqueName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    // Image uploaded successfully
                } else {
                    header('Location: index.php?action=adminDashboard&error=upload_failed');
                    exit();
                }
            }

            $productModel = $this->productController->getProductModel();
            $success = $productModel->update($productId, $name, $price, $imagePath, $description, $qtt);

            if ($success) {
                header('Location: index.php?action=adminDashboard&success=product_updated');
                exit();
            } else {
                header('Location: index.php?action=adminDashboard&error=update_failed');
                exit();
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Requête de mise à jour invalide.']);
            exit();
        }
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0.00;
            $description = $_POST['description'] ?? '';
            $qtt = $_POST['qtt'] ?? 0;
            $imagePath = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../public/images/';
                $uniqueName = uniqid() . '_' . basename($_FILES['image']['name']);
                $imagePath = $uploadDir . $uniqueName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    // Image uploaded successfully
                } else {
                    header('Location: index.php?action=adminDashboard&error=upload_failed');
                    exit();
                }
            } else {
                $imagePath = ""; //important to set to ""
            }

            $productModel = $this->productController->getProductModel();
            $success = $productModel->insert($name, $price, $imagePath, $description, $qtt);

            if ($success) {
                header('Location: index.php?action=adminDashboard&success=product_added');
                exit();
            } else {
                header('Location: index.php?action=adminDashboard&error=add_failed');
                exit();
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Requête d\'ajout de produit invalide.']);
            exit();
        }
    }

    public function deleteMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $messageId = $_POST['id'];
            $success = $this->adminModel->deleteMessage($messageId);

            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
            exit();
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Requête de suppression de message invalide.']);
            exit();
        }
    }

    public function showProductAnalytics() {
        if (isset($_SESSION['admin_id'])) {
            // Keep using productModel->getAllProductPublicite() as requested
            $publiciteProducts = $this->productModel->getAllProductPublicite();
            $this->render('admin/dashboard', ['publiciteProducts' => $publiciteProducts, 'current_action' => 'productAnalytics']);
        } else {
            header('Location: index.php?action=adminLogin');
            exit();
        }
    }

    /**
     * Handles the deletion of a publicite_produit entry.
     */
    public function deletePubliciteProduct() { // <<< NEW METHOD
        if (isset($_GET['id'])) {
            $id_pub_to_delete = htmlspecialchars($_GET['id']);

            $success = $this->publiciteProduitModel->deletePubliciteProduct($id_pub_to_delete);

            if ($success) {
                // Redirect back to the product analytics page after successful deletion
                header('Location: index.php?action=productAnalytics&success=publicite_deleted');
                exit();
            } else {
                // Handle error case
                header('Location: index.php?action=productAnalytics&error=publicite_delete_failed');
                exit();
            }
        } else {
            // If no ID is provided, redirect with an error
            header('Location: index.php?action=productAnalytics&error=invalid_publicite_id');
            exit();
        }
    }




    public function editPubliciteProduct() { // <<< NEW METHOD (for displaying the form)
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?action=adminLogin');
            exit();
        }

        if (isset($_GET['id'])) {
            $id_pub = htmlspecialchars($_GET['id']);
            $publiciteProduct = $this->publiciteProduitModel->getPubliciteProductByIdPub($id_pub);

            if ($publiciteProduct) {
                $this->render('admin/edit_publicite_product', [ // Assuming a new view file
                    'publiciteProduct' => $publiciteProduct,
                    'current_action' => 'editPubliciteProduct'
                ]);
            } else {
                header('Location: index.php?action=productAnalytics&error=publicite_not_found');
                exit();
            }
        } else {
            header('Location: index.php?action=productAnalytics&error=no_publicite_id');
            exit();
        }
    }

    /**
     * Handles the submission of the form to update a publicite_produit entry.
     */
     public function updatePubliciteProduct() { // <<< MODIFIED METHOD
        if (!isset($_SESSION['admin_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Non authentifié.']);
            exit();
        }

        // Ensure it's a POST request and all necessary data is present
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pub'], $_POST['taille'], $_POST['couleur'], $_POST['description_generale'])) {
            $id_pub = htmlspecialchars($_POST['id_pub']);
            $taille = $_POST['taille'];
            $couleur = $_POST['couleur'];
            $description_generale = $_POST['description_generale'];

            $success = $this->publiciteProduitModel->updatePubliciteProduct($id_pub, $taille, $couleur, $description_generale);

            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Publicité mise à jour avec succès.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Échec de la mise à jour de la publicité.']);
            }
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Requête invalide ou données manquantes.']);
            exit();
        }
    }













}