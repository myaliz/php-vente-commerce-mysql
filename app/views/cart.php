<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Basic styles for demonstration, replace with your actual CSS */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .topbar { display: flex; justify-content: space-between; align-items: center; background-color: #333; color: white; padding: 10px 20px; }
        .topbar a { color: white; text-decoration: none; margin: 0 10px; }
        .container { max-width: 900px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 30px; }
        .cart-item { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding: 15px 0; }
        .cart-item:last-child { border-bottom: none; }
        .item-info { display: flex; align-items: center; flex-grow: 1; }
        .item-image img { width: 80px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 4px; }
        .item-name { font-weight: bold; margin-right: 20px; }
        .quantity-controls { display: flex; align-items: center; }
        .quantity-controls button { background-color: #007bff; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; font-size: 1em; }
        .quantity-controls span { margin: 0 10px; font-weight: bold; }
        .item-total { font-weight: bold; color: #007bff; width: 100px; text-align: right; }
        .remove-button { background: none; border: none; color: #dc3545; font-size: 1.2em; cursor: pointer; margin-left: 20px; }
        .cart-total { text-align: right; font-size: 1.5em; font-weight: bold; margin-top: 30px; padding-top: 20px; border-top: 2px solid #007bff; }
        .cart-actions { display: flex; justify-content: flex-end; margin-top: 20px; }
        .cart-actions button { background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 1em; margin-left: 10px; }
        .cart-actions .delete-all-button { background-color: #dc3545; }
        .empty-cart { text-align: center; color: #666; margin-top: 50px; font-size: 1.2em; }
        .attention{color:red;}
        .toast-message {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .toast-message.show {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="spacer"></div>
        <div class="menu">
            <a href="index.php?action=showAds">Home</a>
            <a href="index.php?action=showProductDetailPub">products on promotion</a> <a href="/contact">Contact</a>
        </div>
        <div class="login-link" style="margin-right: 20px;">
            <a href="/login"><i class="fas fa-user"></i> Log In</a>
        </div>
    </div>

    <div class="container">
        <p class="attention">Veuillez verifier bien la quantite, diminuer ou ajouter vos produits dans le panier</p>
        <h1>Your Cart</h1>
        <?php if (!empty($cartDetails)): ?>
            <?php
            $totalPrice = 0;
            foreach ($cartDetails as $item):
                $product = $item['product'];
                $quantity = $item['quantity'];
                $itemTotal = $item['total'];
                $totalPrice += $itemTotal;
            ?>
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-image">
                            <img src="<?= htmlspecialchars($product['image'] ?? 'path/to/default-image.png') ?>" alt="<?= htmlspecialchars($product['name'] ?? 'Product Image') ?>">
                        </div>
                        <span class="item-name"><?= htmlspecialchars($product['name'] ?? 'Unknown Product') ?></span>
                        <div class="quantity-controls">
                            <button onclick="updateQuantity('<?= htmlspecialchars($product['name']) ?>', <?= $quantity ?>, -1)">-</button>
                            <span><?= $quantity ?></span>
                            <button onclick="updateQuantity('<?= htmlspecialchars($product['name']) ?>', <?= $quantity ?>, 1)">+</button>
                        </div>
                    </div>
                    <span class="item-total"><?= number_format($itemTotal, 2) ?> €</span>
                    <button class="remove-button" onclick="removeItem('<?= htmlspecialchars($product['name']) ?>')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            <?php endforeach; ?>
            <div class="cart-total">
                Total: <?= number_format($totalPrice, 2) ?> €
            </div>
            <div class="cart-actions">
                <button class="delete-all-button" onclick="clearCart()">
                    <i class="fas fa-trash-alt"></i> Supprimer tout
                </button>
                <button class="checkout-button" onclick="validatePurchase()">
                    <i class="fas fa-check-circle"></i> Valider l'achat
                </button>
            </div>
        <?php else: ?>
            <p class="empty-cart"> ___ Empty Cart. ___</p>
        <?php endif; ?>
    </div>

    <script>
        function updateQuantity(productName, currentQuantity, change) {
            let newQuantity = currentQuantity + change;

            // Prevent negative quantities
            if (newQuantity < 0) {
                // If decreasing to 0 or less, confirm removal
                if (confirm(`Voulez-vous supprimer entièrement "${productName}" du panier ?`)) {
                    removeItem(productName);
                }
                return; // Stop execution if user cancels or item is removed
            }

            // If quantity is 0 after decrease, remove the item
            if (newQuantity === 0) {
                removeItem(productName);
                return;
            }

            // Send update to the server
            fetch('index.php?action=updateCartQuantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product=' + encodeURIComponent(productName) + '&newQuantity=' + newQuantity
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text || 'Network response was not ok'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.reload(); // Reload page to reflect changes
                } else {
                    showToast(data.message || 'Erreur lors de la mise à jour de la quantité');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Erreur: ' + error.message);
            });
        }

        function removeItem(productName) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet article du panier ?')) {
                fetch('index.php?action=removeFromCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'productToRemove=' + encodeURIComponent(productName),
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text || 'Network response was not ok'); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('Article supprimé !');
                        window.location.reload();
                    } else {
                        showToast(data.message || 'Erreur lors de la suppression de l\'article');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Erreur: ' + error.message);
                });
            }
        }

        function clearCart() {
            if (confirm('Êtes-vous sûr de vouloir vider entièrement votre panier ? Cette action est irréversible.')) {
                fetch('index.php?action=clearCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'clear=true'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text || 'Erreur réseau');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('Panier vidé avec succès !');
                        window.location.reload();
                    } else {
                        showToast('Erreur: ' + (data.message || 'Action échouée'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Erreur lors de la suppression: ' + error.message);
                });
            }
        }

     function validatePurchase() {
        // Instead of directly finalizing, redirect to the confirmation page
        window.location.href = 'index.php?action=showCheckoutConfirmation'; // IMPORTANT CHANGE HERE
    }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.textContent = message;
            document.body.appendChild(toast);
            // Trigger reflow to apply transition
            void toast.offsetWidth;
            toast.classList.add('show');
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
</body>
</html>