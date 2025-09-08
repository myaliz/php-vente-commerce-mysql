<?php
// Vérification des données nécessaires
if (!isset($order) || !isset($total)) {
    die('Données de commande manquantes');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Paiement Sécurisé</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    /* Un dégradé plus doux et moderne */
    background: linear-gradient(135deg, #a8c0ff 0%, #3f2b96 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
    box-sizing: border-box;
    color: #333;
}

.payment-page-container {
    display: flex;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée et douce */
    overflow: hidden;
    width: 100%;
    max-width: 950px; /* Légèrement plus large pour plus d'espace */
    animation: fadeIn 0.5s ease-out; /* Animation d'apparition */
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.left-panel {
    background-color: #f7f8fc;
    padding: 40px;
    width: 40%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border-right: 1px solid #eee; /* Séparateur visuel */
}

.order-summary h2 {
    font-size: 1.5em; /* Un peu plus grand */
    color: #333;
    margin-bottom: 25px;
    font-weight: 700; /* Plus de poids */
}

.order-item,
.order-total {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px; /* Plus d'espace */
    font-size: 1em; /* Légèrement plus grand */
}

.order-item span:first-child,
.order-total span:first-child {
    color: #555;
}

.order-item span:last-child,
.order-total span:last-child {
    font-weight: 600; /* Plus de poids */
    color: #333;
}

.order-summary hr {
    border: 0;
    border-top: 1px dashed #e0e0e0; /* Ligne pointillée plus douce */
    margin: 25px 0;
}

.order-total {
    font-weight: 700; /* Très gras */
    font-size: 1.25em; /* Nettement plus grand */
    color: #3f2b96; /* Couleur du dégradé de fond pour le total */
}

.order-total .total-amount-display {
    color: #3f2b96;
}

.branding {
    font-size: 0.85em;
    color: #999;
    text-align: center;
    margin-top: 40px;
}

.payment-form-main-container {
    padding: 40px;
    width: 60%;
}

.payment-form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px; /* Plus d'espace */
}

.payment-form-header h1 {
    font-size: 2em; /* Plus grand et impactant */
    color: #333;
    margin: 0;
    font-weight: 700;
}

#secure-badge {
    width: 50px; /* Plus grande */
    height: 50px;
    filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1)); /* Petite ombre pour l'icône */
}

#payment-method-selection-container {
    margin-bottom: 35px;
}

#payment-method-selection-container h2 {
    font-size: 1.3em;
    color: #333;
    margin-bottom: 18px;
    font-weight: 600;
}

.payment-method-options {
    display: flex;
    gap: 15px; /* Plus d'espace entre les boutons */
    margin-bottom: 25px;
}
.payment-method-btn[data-method="interac"] { /* Changement ici */
    background-color: #FFD700;
    color: #333;
}
.payment-method-btn[data-method="card"] { /* Changement ici */
    background-color:#e83a6c ;
    color: #fbfcfc;
}
.payment-method-btn[data-method="paypal"] { /* Changement ici */
    background-color: WHITE;
    color:#8180c7  ;
}

.payment-method-btn {
    flex-grow: 1;
    padding: 14px 15px; /* Plus de padding */
    background-color: #f0f4f8; /* Un fond plus clair */
    color: #555;
    border: 1px solid #dcdfe4; /* Bordure plus douce */
    border-radius: 8px; /* Bords légèrement plus arrondis */
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease; /* Transition plus fluide */
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-method-btn:hover {
    background-color: #e5eaf0;
    border-color: #c7cbd1;
    transform: translateY(-2px); /* Petit effet de survol */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08); /* Ombre au survol */
}

.payment-method-btn.active {
    background-color: #3f2b96; /* Bleu foncé du dégradé */
    color: white;
    border-color: #3f2b96;
    box-shadow: 0 5px 15px rgba(63, 43, 150, 0.3); /* Ombre colorée */
    transform: translateY(-2px); /* Garde l'effet de survol actif */
}

.payment-method-btn.active .payment-method-icon {
    filter: brightness(0) invert(1);
}

.payment-method-icon {
    width: 22px; /* Icônes légèrement plus grandes */
    height: 22px;
    margin-right: 10px;
    object-fit: contain;
}

.payment-method-content {
    padding-top: 25px; /* Plus d'espace */
    border-top: 1px solid #e9ecef; /* Séparateur plus fin */
    margin-top: 25px;
}

.payment-method-content h3 {
    font-size: 1.4em;
    margin-bottom: 25px;
    color: #333;
    font-weight: 600;
}

/* --- Styles des Formulaires (Génériques et Spécifiques au Paiement) --- */

.form-group {
    margin-bottom: 22px; /* Espacement entre les groupes de formulaires */
}

.form-group label {
    display: block;
    font-size: 0.95em;
    font-weight: 600;
    margin-bottom: 8px;
    color: #444; /* Un gris plus foncé */
    transition: color 0.2s ease;
}

/* Style général pour TOUS les champs input text, email, number, tel, password */
.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="number"],
.form-group input[type="tel"],
.form-group input[type="password"] {
    width: calc(100% - 28px); /* padding 14px * 2 */
    padding: 14px;
    border: 1px solid #dcdfe4;
    border-radius: 8px;
    font-size: 1.05em;
    transition: border-color 0.3s, box-shadow 0.3s, background-color 0.3s;
    background-color: #fcfcfc; /* Un léger fond pour les inputs */
    color: #333; /* Couleur du texte dans l'input */
    box-sizing: border-box; /* Important pour que width fonctionne comme prévu */
}

/* Focus state pour TOUS les inputs */
.form-group input[type="text"]:focus,
.form-group input[type="email"]:focus,
.form-group input[type="number"]:focus,
.form-group input[type="tel"]:focus,
.form-group input[type="password"]:focus {
    border-color: #3f2b96;
    box-shadow: 0 0 0 4px rgba(63, 43, 150, 0.15); /* Ombre plus visible */
    outline: none;
    background-color: #fff;
}

/* Wrapper pour le numéro de carte avec icône (spécifique carte) */
.card-number-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.card-number-wrapper input {
    padding-right: 60px !important; /* Espace suffisant pour l'icône de carte */
}

#card-logo {
    position: absolute;
    right: 15px;
    width: 40px;
    height: auto;
    max-height: 30px; /* Limite la hauteur de l'icône */
    object-fit: contain;
    opacity: 0.7; /* Légèrement transparent */
    transition: opacity 0.3s ease;
}

/* Ligne des champs expiration et CVV (spécifique carte) */
.form-row {
    display: flex;
    gap: 20px; /* Espace entre les deux champs */
    margin-bottom: 22px; /* Assure un espacement en dessous */
}

.form-row .form-group {
    flex: 1; /* Chaque groupe prend une part égale */
    margin-bottom: 0; /* Pas de marge en bas, elle est gérée par le form-row */
}

/* Style des messages d'erreur sous les inputs */
.error-message {
    font-size: 0.85em;
    color: #d32f2f; /* Rouge vif pour les erreurs */
    margin-top: 6px;
    min-height: 1.2em; /* Réserve de l'espace pour éviter le saut de mise en page */
    font-weight: 500;
    opacity: 0; /* Caché par défaut */
    transform: translateY(-5px); /* Petite animation */
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Afficher le message d'erreur */
input.invalid + .error-message {
    opacity: 1;
    transform: translateY(0);
}

/* Style des inputs invalides */
input.invalid {
    border-color: #d32f2f !important; /* Bordure rouge */
    background-color: #ffebee !important; /* Fond légèrement rouge */
}

input.invalid:focus {
    box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.15) !important; /* Ombre rouge au focus */
}


#pay-button-card,
.external-payment-button {
    width: 100%;
    padding: 16px; /* Plus de padding */
    color: white;
    border: none;
    border-radius: 8px; /* Bords arrondis */
    font-size: 1.15em; /* Texte plus grand */
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.1s, box-shadow 0.3s;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 25px; /* Plus d'espace au-dessus du bouton */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Ombre discrète */
}

#pay-button-card {
    background-color: #3f2b96; /* Utilise la couleur accent */
    box-shadow: 0 5px 15px rgba(63, 43, 150, 0.2); /* Ombre spécifique au bouton carte */
}

#pay-button-card:hover {
    background-color: #2e1f74; /* Variante plus foncée */
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(63, 43, 150, 0.3); /* Ombre spécifique au survol carte */
}

.external-payment-button.paypal-button {
    background-color: #0070ba; /* Un bleu PayPal plus standard */
}

.external-payment-button.paypal-button:hover {
    background-color: #005a92;
}

.external-payment-button.paypal-button .payment-method-icon {
    filter: brightness(0) invert(1);
}

.external-payment-button.interac-button {
    background-color: #FFD700; /* Un vert Interac plus distinct */
}

.external-payment-button.interac-button:hover {
    background-color: yellow;
}

#pay-button-card:active,
.external-payment-button:active {
    transform: scale(0.98);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

#pay-button-card:disabled,
.external-payment-button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.button-amount {
    margin-left: 10px; /* Plus d'espace */
    font-weight: 600;
    opacity: 1; /* Pas de transparence */
}

.spinner {
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #fff;
    width: 20px; /* Plus grand */
    height: 20px;
    animation: spin 1s linear infinite;
    margin-left: 12px;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.payment-message {
    margin-top: 20px; /* Plus d'espace */
    padding: 15px; /* Plus de padding */
    border-radius: 8px; /* Plus arrondis */
    text-align: center;
    font-size: 1em;
    font-weight: 500;
    line-height: 1.5;
}

.payment-message.success {
    background-color: #e6f7e9;
    color: #388e3c;
    border: 1px solid #b7e0c0;
}

.payment-message.error {
    background-color: #ffebee;
    color: #d32f2f;
    border: 1px solid #f5c6cb;
}

.payment-message.info {
    background-color: #e3f2fd; /* Bleu plus doux */
    color: #1976d2; /* Bleu plus profond */
    border: 1px solid #90caf9; /* Bleu clair */
}

.interac-details {
    background-color: #fcfcfc; /* Un fond plus clair */
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px; /* Plus de padding */
    margin-bottom: 25px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Petite ombre interne */
}

.interac-details p {
    margin: 10px 0; /* Plus d'espace */
    font-size: 1em;
    line-height: 1.6;
}

.interac-details strong {
    color: #333;
    font-weight: 700;
}

.interac-details small {
    font-size: 0.9em;
    color: #888;
}

#copy-interac-answer {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0 8px; /* Plus de padding */
    vertical-align: middle;
    transition: opacity 0.2s, transform 0.1s;
}

.copy-icon-img {
    width: 20px; /* Plus grande */
    height: 20px;
    opacity: 0.7;
}

#copy-interac-answer:hover .copy-icon-img {
    opacity: 1;
    transform: scale(1.1);
}

/* Responsive Design */
@media (max-width: 850px) { /* Ajustement du breakpoint */
    .payment-page-container {
        flex-direction: column;
        max-width: 550px;
    }

    .left-panel,
    .payment-form-main-container {
        width: 100%;
        padding: 30px; /* Moins de padding sur mobile */
    }

    .left-panel {
        order: 2;
        border-top: 1px solid #e0e0e0;
        border-right: none; /* Enlève la bordure droite sur mobile */
    }

    .payment-form-main-container {
        order: 1;
    }

    .payment-method-options {
        flex-direction: column;
        gap: 12px;
    }

    .form-row {
        flex-direction: column;
        gap: 0;
    }

    .form-row .form-group {
        margin-bottom: 18px;
    }

    .payment-form-header h1 {
        font-size: 1.8em;
    }

    #secure-badge {
        width: 40px;
        height: 40px;
    }
}
    </style>
</head>
<body>
    <div class="payment-page-container">
        <div class="left-panel">
            <div class="order-summary">
                <h2>Récapitulatif de la commande</h2>
                
                <?php 
                $productModel = new \App\Models\Product();
                foreach ($order['cart_items'] as $productName => $quantity) {
                    $product = $productModel->getByName($productName);
                    if ($product) {
                        echo '<div class="order-item">';
                        echo '<span>' . htmlspecialchars($productName) . ' (x' . $quantity . ')</span>';
                        echo '<span>$' . number_format($product['price'] * $quantity, 2) . '</span>';
                        echo '</div>';
                    }
                }
                ?>
                
                <hr>
                <div class="order-total">
                    <span>Total</span>
                    <span class="total-amount-display">$<?php echo number_format($total, 2); ?></span>
                </div>
            </div>
            
           <div class="customer-info">
    <h2>Informations client</h2>
    <p><strong>Nom :</strong> <?php echo !empty($order['customer_info']['nom']) ? htmlspecialchars($order['customer_info']['nom']) : 'Non spécifié'; ?></p>
    <p><strong>Prénom :</strong> <?php echo !empty($order['customer_info']['prenom']) ? htmlspecialchars($order['customer_info']['prenom']) : 'Non spécifié'; ?></p>
    <p><strong>Email :</strong> <?php echo !empty($order['customer_info']['email']) ? htmlspecialchars($order['customer_info']['email']) : 'Non spécifié'; ?></p>
    <p><strong>Adresse :</strong> <?php echo !empty($order['customer_info']['adresse']) ? htmlspecialchars($order['customer_info']['adresse']) : 'Non spécifié'; ?></p>
    <p><strong>Téléphone :</strong> <?php echo !empty($order['customer_info']['telephone']) ? htmlspecialchars($order['customer_info']['telephone']) : 'Non spécifié'; ?></p>
</div>
            
            <div class="branding">
                <p>Propulsé par AI Web Crafter</p>
            </div>
        </div>

        <div class="payment-form-main-container">
            <div class="payment-form-header">
                <h1>Paiement Sécurisé</h1>
                <img id="secure-badge" src="shield_icon.png" alt="Paiement Sécurisé">
            </div>

            <div id="payment-method-selection-container">
                <h2>Choisissez votre méthode de paiement :</h2>
                <div class="payment-method-options">
                    <button class="payment-method-btn active" data-method="card">Carte Bancaire</button>
                    <button class="payment-method-btn" data-method="paypal">PayPal</button>
                    <button class="payment-method-btn" data-method="interac">Interac</button>
                </div>
            </div>

            <div id="card-payment-content" class="payment-method-content" style="display:block;">
                <h3>Paiement par Carte Bancaire</h3>
                <form id="card-payment-form">
                    <div class="form-group">
                        <label for="card-name">Nom du titulaire</label>
                        <input type="text" id="card-name" 
                               value="<?php echo htmlspecialchars($order['customer_info']['prenom'] . ' ' . $order['customer_info']['nom']); ?>" 
                               required>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Numéro de carte</label>
                        <div class="card-number-wrapper">
                            <input type="text" id="card-number" placeholder="0000 0000 0000 0000" required>
                            <img id="card-logo" src="img/generic_card.png" alt="Card Logo">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="card-expiry">Date d'expiration</label>
                            <input type="text" id="card-expiry" placeholder="MM/AA" required>
                        </div>
                        <div class="form-group">
                            <label for="card-cvv">CVV</label>
                            <input type="text" id="card-cvv" placeholder="123" required>
                        </div>
                    </div>
                    <button type="submit" id="pay-button-card">
                        Payer $<?php echo number_format($total, 2); ?>
                    </button>
                </form>
            </div>

            <div id="paypal-payment-content" class="payment-method-content" style="display:none;">
                <h3>Paiement avec PayPal</h3>
                <p>Vous serez redirigé vers PayPal pour compléter votre paiement de <strong>$<?php echo number_format($total, 2); ?></strong>.</p>
                <button class="external-payment-button paypal-button">
                    <img src="img/paypal_icon.png" class="payment-method-icon" alt="PayPal">
                    Payer avec PayPal
                </button>
            </div>

            <div id="interac-payment-content" class="payment-method-content" style="display:none;">
                <h3>Paiement avec Interac</h3>
                <div class="interac-details">
                    <p>Envoyez un virement Interac à :</p>
                    <p><strong>paiement@votresite.com</strong></p>
                    <p>Montant : <strong>$<?php echo number_format($total, 2); ?></strong></p>
                    <p><strong>Email du bénéficiaire :</strong> <?php echo htmlspecialchars($order['customer_info']['email']); ?></p>
                    <p><strong>Nom du bénéficiaire :</strong> <?php echo htmlspecialchars($order['customer_info']['prenom'] . ' ' . htmlspecialchars($order['customer_info']['nom'])); ?></p>
                </div>
                <button class="external-payment-button interac-button">
                    <img src="img/interac_icon.png" class="payment-method-icon" alt="Interac">
                    J'ai envoyé le paiement
                </button>
            </div>

            <div id="general-payment-message" class="payment-message info">
                Sélectionnez votre méthode de paiement préférée.
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Gestion des boutons de méthode de paiement
            const methodButtons = document.querySelectorAll(".payment-method-btn");
            const contentBlocks = {
                card: document.getElementById("card-payment-content"),
                paypal: document.getElementById("paypal-payment-content"),
                interac: document.getElementById("interac-payment-content")
            };

            methodButtons.forEach((button) => {
                button.addEventListener("click", (e) => {
                    e.preventDefault();
                    const method = button.dataset.method;

                    // Retire l'état actif des autres boutons
                    methodButtons.forEach((btn) => btn.classList.remove("active"));
                    button.classList.add("active");

                    // Masquer tous les contenus
                    Object.values(contentBlocks).forEach((el) => {
                        el.style.display = "none";
                    });

                    // Afficher le contenu choisi
                    if (contentBlocks[method]) {
                        contentBlocks[method].style.display = "block";
                    }
                });
            });

            // Validation du formulaire de carte
            document.getElementById('card-payment-form').addEventListener('submit', function(e) {
                e.preventDefault();
                // Ici vous pouvez ajouter la logique de traitement du paiement
                alert('Paiement traité avec succès!');
            });
        });


        window.onpageshow = function(event) {
    if (event.persisted) {
        window.location.reload();
    }
};

// Vérifier la fraîcheur des données (max 30 minutes)
const lastUpdated = new Date("<?php echo $_SESSION['order_details']['created_at']; ?>").getTime();
const now = new Date().getTime();
const thirtyMinutes = 30 * 60 * 1000;

if (now - lastUpdated > thirtyMinutes) {
    window.location.href = 'index.php?action=showCart';
}
    </script>
</body>
</html>