<?php
// Enable full error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session if not already started
// It's good practice to ensure session is started early for all requests
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require Controllers
require_once '../app/controllers/Controller.php';
require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/CartController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/MessageController.php';
require_once '../app/controllers/PaymentController.php';



// Require Models
require_once '../app/models/Model.php'; // Base Model (assuming it handles DB connection)
require_once '../app/models/Product.php';
require_once '../app/models/Admin.php';
require_once '../app/models/Message.php';
require_once '../app/models/PubliciteProduit.php'; 




// Instanciez le contrôleur

// Use statements for namespaces
use App\Controllers\PaymentController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\AdminController;
use App\Controllers\MessageController;

// Get the requested action from the URL, default to 'showAds'
$action = $_GET['action'] ?? 'showAds';

// --- Instantiate controllers ONCE before the switch statement ---

$productController = new ProductController();
$cartController = new CartController();
$adminController = new AdminController();
$messageController = new MessageController();
$paymentController = new PaymentController();

// --- Routing Logic ---
switch ($action) {
    // Public Product Actions
    case 'showAds':
        $productController->showAds();
        break;
    case 'storeProduct': // This likely means saving a product, but could be "show product page"
        $productController->storeProduct();
        break;
  case 'showProductDetail': // <<< NEW ROUTING CASE
        $productController->showProductDetail();
        break;

    // Cart Actions
case 'addToCart':
        $cartController->addToCart();
        break;
    case 'showCart':
        $cartController->showCart();
        break;
    case 'removeFromCart':
        $cartController->removeFromCart();
        break;
    case 'updateCartQuantity':
        $cartController->updateCartQuantity();
        break;
   
     case 'updateCartQuantity':
        $cartController->updateCartQuantity(); // Now expects 'newQuantity'
        break;
        case 'setProductQuantityInCart':
    $cartController->setProductQuantityInCart();
    break;
    case 'clearCart':
        $cartController->clearCart();
        break;
         case 'showCheckoutConfirmation': // NEW ACTION to display the confirmation page
        $cartController->showCheckoutConfirmation();
        break;
    case 'finalizePurchase': // NEW ACTION to handle the final confirmation
        $cartController->finalizePurchase();
        break;
    case 'validatePurchase': // Add this new case
        $cartController->validatePurchase();
        break;

    // Admin Authentication & Dashboard Actions
    case 'adminLogin':
        $adminController->login();
        break;
    case 'adminPage': // Likely renders the login form (redundant if 'adminLogin' handles GET requests)
        require_once '../app/views/login_admin.php'; // Direct view rendering without controller method call
        break;
    case 'adminDashboard':
        $adminController->dashboard();
        break;
    case 'adminLogout':
        $adminController->logout();
        break;

    // Admin Product Management (Standard Products)
    case 'deleteProduct':
        $adminController->deleteProduct();
        break;
    case 'updateProduct':
        $adminController->updateProduct();
        break;
    case 'addProduct':
        $adminController->addProduct();
        break;

    // Messaging Actions

    case 'submitMessage':
        $messageController->submitMessage();
        break;
    case 'showMessengerMessages': // Admin view for messages
        $adminController->showMessengerMessages();
        break;
    case 'deleteMessage':
        $adminController->deleteMessage();
        break;




       // New case for Product Analytics
    // Product Analytics
    case 'productAnalytics':
        $adminController->showProductAnalytics();
        break;

    case 'deletePubliciteProduct':
        $adminController->deletePubliciteProduct();
        break;
   
    case 'updatePubliciteProduct': // This will be the AJAX endpoint
        $adminController->updatePubliciteProduct();
        break;


case 'showProductDetail':
    $productController->showProductDetail();
    break;


    // Ajoutez payements ici    
case 'processPayment':
    $paymentController->processPayment();
    break;
case 'showPaymentPage':
    $paymentController->showPaymentPage();
    break;


    // Default Fallback
    default:
        $productController->showAds();
        break;
}