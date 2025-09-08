<?php
namespace App\Controllers;

class PaymentController extends Controller {
   
    

public function showPaymentPage() {
    // Vérifier que la commande existe et est récente
    if (!isset($_SESSION['order_details']) || empty($_SESSION['order_details']['customer_info'])) {
        header('Location: index.php?action=showCart');
        exit();
    }

    // Calculer le total à jour
    $productModel = new \App\Models\Product();
    $total = 0;
    foreach ($_SESSION['order_details']['cart_items'] as $productName => $quantity) {
        $product = $productModel->getByName($productName);
        if ($product) {
            $total += $product['price'] * $quantity;
        }
    }

    // Mettre à jour le total dans la session
    $_SESSION['order_details']['total_price'] = $total;

    $this->render('payment_page', [
        'order' => $_SESSION['order_details'],
        'total' => $total
    ]);
}





}