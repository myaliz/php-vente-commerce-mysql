<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - Détails du Produit</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Minimal CSS for visibility - replace with your actual CSS */
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 900px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; gap: 30px; }
        .product-detail-card { display: flex; flex-wrap: wrap; width: 100%; }
        .product-image-area { flex: 1; min-width: 300px; text-align: center; }
        .product-image-area img { max-width: 100%; height: auto; border-radius: 8px; }
        .product-info-area { flex: 2; min-width: 350px; padding-left: 20px; }
        .product-title { font-size: 2em; margin-bottom: 10px; }
        .product-price { font-size: 1.5em; color: #007bff; font-weight: bold; display: block; margin-bottom: 20px; }
        .product-description { margin-bottom: 20px; line-height: 1.6; }
        .product-specs p { margin: 5px 0; }
        .product-specs strong { color: #555; }
        .quantity-selector { margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; }
        .quantity-control { display: flex; align-items: center; margin-top: 10px; margin-bottom: 15px; }
        .quantity-btn { background-color: #007bff; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; font-size: 1em; }
        .quantity-input { width: 50px; text-align: center; border: 1px solid #ccc; border-radius: 4px; padding: 5px; margin: 0 10px; }
        .total-price-container { font-size: 1.2em; font-weight: bold; }
        .total-price-amount { color: #28a745; }
        .action-buttons { margin-top: 30px; display: flex; gap: 15px; }
        .action-buttons button { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; font-weight: bold; }
        .add-to-cart { background-color: #ffc107; color: #333; }
        .buy-now { background-color: #28a745; color: white; }
        .back-link { display: block; margin-top: 20px; color: #007bff; text-decoration: none; }
        .back-link i { margin-right: 5px; }
        footer { margin-top: 40px; padding: 20px; background-color: #333; color: white; text-align: center; }
        .footer-contact p { margin: 5px 0; }
        .footer-contact i { margin-right: 8px; color: #007bff; }
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

<div class="container">
    <div class="product-detail-card">
        <div class="product-image-area">
            <img src="<?= htmlspecialchars($product['image'] ?? 'path/to/default-image.png') ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="quantity-selector">
                <label for="product-quantity">Quantité :</label>
                <div class="quantity-control">
                    <button class="quantity-btn minus" onclick="changeQuantity(-1)">-</button>
                    <input type="number" id="product-quantity" name="quantity"
                           min="1" max="<?= $product['qtt'] ?? 1000 ?>"
                           value="1" class="quantity-input">
                    <button class="quantity-btn plus" onclick="changeQuantity(1)">+</button>
                </div>
                <div class="total-price-container">
                    <span class="total-price-label">Total :</span>
                    <span id="total-price" class="total-price-amount"><?= number_format($product['price'], 2, ',', ' ') ?> $</span>
                </div>
            </div>
        </div>
        <div class="product-info-area">
            <div>
                <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
                <span class="product-price">
                    <?= number_format($product['price'], 2, ',', ' ') ?> $
                </span>

                <?php if (!empty($product['description'])): ?>
                    <p class="product-description">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($product['taille']) || !empty($product['couleur']) || !empty($product['description_generale']) || (isset($product['qtt']) && $product['qtt'] !== null)): ?>
                    <div class="product-specs">
                        <?php if (!empty($product['taille'])): ?>
                            <p><strong><i class="fas fa-ruler-combined"></i> Taille:</strong> <?= htmlspecialchars($product['taille']) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($product['couleur'])): ?>
                            <p><strong><i class="fas fa-palette"></i> Couleur:</strong> <?= htmlspecialchars($product['couleur']) ?></p>
                        <?php endif; ?>

                        <?php if (isset($product['qtt']) && $product['qtt'] !== null): ?>
                            <p><strong><i class="fas fa-boxes"></i> Quantité disponible:</strong> <?= htmlspecialchars($product['qtt']) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($product['description_generale'])): ?>
                            <p><strong><i class="fas fa-info-circle"></i> Description complète:</strong><br>
                                <?= nl2br(htmlspecialchars($product['description_generale'])) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="action-buttons">
                <button class="add-to-cart" onclick="addToCartDetail()">
                    <i class="fas fa-cart-plus"></i> Ajouter au panier
                </button>
                <button class="buy-now" onclick="buyNow()">
                    <i class="fas fa-credit-card"></i> Acheter maintenant
                </button>
            </div>

            <a href="index.php?action=showAds" class="back-link">
                <i class="fas fa-arrow-left"></i> Retour aux produits
            </a>
            <a href="index.php?action=showCart" class="back-link">
                <i class="fas fa-shopping-cart"></i> Aller au panier
            </a>
        </div>
    </div>
</div>

<footer>
    <div class="footer-contact">
        <p><i class="fas fa-phone"></i> +1 418 446 8760</p>
        <p><i class="fas fa-envelope"></i> benalizied83@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i> 6525 rue Hochelaga H1N 1X7</p>
    </div>
</footer>

<script>
    // Function to show toast messages (reused from cart.php)
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.textContent = message;
        document.body.appendChild(toast);
        void toast.offsetWidth; // Trigger reflow to apply transition
        toast.classList.add('show');
        setTimeout(() => toast.remove(), 3000);
    }

    // Quantity controls and total price calculation
    function changeQuantity(change) {
        const quantityInput = document.getElementById('product-quantity');
        let newValue = parseInt(quantityInput.value) + change;
        const max = parseInt(quantityInput.max);
        const min = parseInt(quantityInput.min);

        if (newValue > max) newValue = max;
        if (newValue < min) newValue = min;

        quantityInput.value = newValue;
        updateTotalPrice(); // Update total price whenever quantity changes
    }

    function updateTotalPrice() {
        const quantity = parseInt(document.getElementById('product-quantity').value);
        // Ensure $product['price'] is always a valid number. Use 0 if not.
        const unitPrice = parseFloat("<?= $product['price'] ?? 0 ?>");
        const totalPrice = quantity * unitPrice;

        document.getElementById('total-price').textContent =
            totalPrice.toFixed(2).replace('.', ',') + ' $';
    }

    // Initialiser le prix total au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalPrice();
    });

    // Add to Cart function (sends current selected quantity)
    function addToCartDetail() {
        const productName = "<?= addslashes($product['name']) ?>";
        const quantity = document.getElementById('product-quantity').value;

        fetch('index.php?action=addToCart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product=${encodeURIComponent(productName)}&quantity=${quantity}`
        })
        .then(response => response.json()) // Expect JSON response
        .then(data => {
            if (data.success) {
                const button = document.querySelector('.add-to-cart');
                const originalText = button.innerHTML;
                // Store original background color to revert properly
                const originalBg = window.getComputedStyle(button).backgroundColor;

                button.innerHTML = `<i class="fas fa-check"></i> ${quantity} ajouté(s) !`;
                button.style.backgroundColor = '#2E7D32'; // Dark green for success
                showToast(data.message); // Show toast message

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.backgroundColor = originalBg; // Revert to original color
                }, 2000);
            } else {
                showToast(data.message || "Erreur lors de l'ajout au panier. Veuillez réessayer.");
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast("Une erreur de connexion s'est produite. Veuillez réessayer.");
        });
    }

    // Buy Now function (sets quantity and redirects to cart page)
    function buyNow() {
        const productName = "<?= addslashes($product['name']) ?>";
        const quantity = document.getElementById('product-quantity').value;

        // Call the new action to SET the quantity
        fetch('index.php?action=setProductQuantityInCart', { // IMPORTANT CHANGE HERE
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product=${encodeURIComponent(productName)}&quantity=${quantity}`
        })
        .then(response => response.json()) // Expect JSON response
        .then(data => {
            if (data.success) {
                // If quantity was set successfully, redirect to cart
                window.location.href = 'index.php?action=showCart';
            } else {
                showToast(data.message || "Erreur lors de l'achat immédiat. Veuillez réessayer.");
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast("Une erreur de connexion s'est produite lors de l'achat immédiat. Veuillez réessayer.");
        });
    }
</script>

</body>
</html>