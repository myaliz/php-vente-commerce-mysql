<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* General Styling */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            top: 0;
        }

        h1, h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-summary, .customer-form {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-name {
            font-weight: 500;
        }

        .order-item-details {
            font-size: 0.9em;
            color: #666;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .form-actions {
            text-align: center;
            margin-top: 20px;
        }

        .form-actions button {
            background-color:#218838;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
         .form-actionss button {
            background-color:rgb(247, 7, 7);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .form-actions button:hover {
            background-color:rgb(14, 175, 148);
        }

        .empty-cart-message {
            text-align: center;
            padding: 50px;
            border: 1px dashed #ccc;
            border-radius: 5px;
            color: #888;
        }

        .confirm-button-container {
            text-align: center;
            margin-top: 30px;
        }

        .back-to-products-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .back-to-products-button:hover {
            background-color: #0056b3;
        }

        .toast-message {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            transform: translateX(-50%);
            bottom: 30px;
            font-size: 17px;
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .toast-message.show {
            visibility: visible;
            opacity: 1;
        }

        .toast-message.success {
            background-color: #28a745;
        }

        .toast-message.error {
            background-color: #dc3545;
        }

        /* Styles for PDF output */
        @media print {
            body, html {
                margin: 0;
                padding: 0;
                background: white;
            }
            
            .container {
                margin: 0;
                padding: 10mm;
                box-shadow: none;
                border: none;
                width: 100%;
            }
            
            .order-summary, .customer-info-display {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            
            .form-actions, .toast-message {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="contentToPrint">
        <h1>Confirmation de votre commande</h1>

        <?php if (!empty($cartDetails)): ?>
            <div class="order-summary">
                <h2>Votre commande</h2>
                <?php foreach ($cartDetails as $item): ?>
                    <div class="order-item">
                        <span class="order-item-name"><?= htmlspecialchars($item['product']['name'] ?? 'Produit Inconnu') ?></span>
                        <span class="order-item-details">
                            Quantité: <strong><?= htmlspecialchars($item['quantity']) ?></strong> |
                            Prix unitaire: <strong><?= number_format($item['product']['price'] ?? 0, 2, ',', ' ') ?> $</strong> |
                            Total: <strong><?= number_format($item['total'] ?? 0, 2, ',', ' ') ?> $</strong>
                        </span>
                    </div>
                <?php endforeach; ?>
                <div style="color:red;text-align: right; margin-top: 20px; font-size: 1.2em; font-weight: bold;">
                    Total de la commande: <?= number_format($totalPrice ?? 0, 2, ',', ' ') ?> $
                </div>
            </div>

            <?php if (isset($_SESSION['order_details']['customer_info'])): ?>
                <div class="customer-info-display">
                    <h2>Informations client confirmées</h2>
                    <p><strong>Nom:</strong> <?= htmlspecialchars($_SESSION['order_details']['customer_info']['nom']) ?></p>
                    <p><strong>Prénom:</strong> <?= htmlspecialchars($_SESSION['order_details']['customer_info']['prenom']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['order_details']['customer_info']['email']) ?></p>
                    <p><strong>Adresse:</strong> <?= htmlspecialchars($_SESSION['order_details']['customer_info']['adresse']) ?></p>
                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($_SESSION['order_details']['customer_info']['telephone']) ?></p>
                    <p><strong>Date de commande:</strong> <?= htmlspecialchars($_SESSION['order_details']['created_at']) ?></p>
                </div>
            <?php else: ?>
                <form method="post" action="index.php?action=finalizePurchase" class="customer-form" id="customerForm">
                    <h2>Informations client</h2>
                    
                    <div class="form-group">
                        <label for="nom" class="required-field">Nom</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom" class="required-field">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="required-field">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="adresse" class="required-field">Adresse</label>
                        <textarea id="adresse" name="adresse" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="telephone" class="required-field">Téléphone</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    
                    <input type="hidden" name="final_total_price" value="<?php echo $totalPrice; ?>">
                    
                    <div class="form-actions">
                        <button type="submit" name="confirm_purchase">Confirmer la commande</button>
                    </div>
                </form>
            <?php endif; ?>

            <div class="form-actionss" style="margin-top: 30px;">
                <button id="printPdfButton" class="back-to-products-button">
                    <i class="fas fa-file-pdf"></i> Imprimer facture PDF
                </button>
            </div>

        <?php else: ?>
            <p class="empty-cart-message">Votre panier est vide. Veuillez ajouter des articles avant de valider votre commande.</p>
            <div class="confirm-button-container">
                <a href="index.php?action=showAds" class="back-to-products-button">
                    <i class="fas fa-arrow-left"></i> Retour aux produits
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div id="toastContainer"></div>

<script>
    // Function to show toast messages
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-message ${type}`;
        toast.textContent = message;
        document.getElementById('toastContainer').appendChild(toast);
        
        // Force reflow
        void toast.offsetWidth;
        
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Handle form submission
    const customerForm = document.getElementById('customerForm');
    if (customerForm) {
        customerForm.addEventListener('submit', function(event) {
            // PHP handles the submission and redirection
        });
    }

    // Handle PDF generation with red stamp
    document.getElementById('printPdfButton').addEventListener('click', function() {
        // Disable button during generation
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération en cours...';
        
        // Create a deep clone of the content
        const element = document.getElementById('contentToPrint');
        const clone = element.cloneNode(true);
        
        // Remove the print button from clone
        const printBtnClone = clone.querySelector('#printPdfButton');
        if (printBtnClone) printBtnClone.remove();
        
        // If form exists in clone (order not yet confirmed)
        const formClone = clone.querySelector('.customer-form');
        if (formClone) {
            // Get current form values
            const formData = {
                nom: document.getElementById('nom')?.value || '',
                prenom: document.getElementById('prenom')?.value || '',
                email: document.getElementById('email')?.value || '',
                adresse: document.getElementById('adresse')?.value || '',
                telephone: document.getElementById('telephone')?.value || ''
            };
            
            // Create customer info HTML
            const customerInfoHTML = `
                <div class="customer-info-display">
                    <h2>Informations client</h2>
                    <p><strong>Nom:</strong> ${formData.nom}</p>
                    <p><strong>Prénom:</strong> ${formData.prenom}</p>
                    <p><strong>Email:</strong> ${formData.email}</p>
                    <p><strong>Adresse:</strong> ${formData.adresse.replace(/\n/g, '<br>')}</p>
                    <p><strong>Téléphone:</strong> ${formData.telephone}</p>
                    <p><strong>Date d'impression:</strong> ${new Date().toLocaleDateString('fr-FR')} ${new Date().toLocaleTimeString('fr-FR')}</p>
                </div>
               <br>
                                  <div> </div>
                                     <br>    <br>    <br>    
                                    <center> <h2 style="display: inline-block; 
           color: red; 
           border: 2px solid red; 
           padding: 5px 15px; 
           
           margin: 10px 0;
           font-weight: normal;
           text-transform: uppercase;
           letter-spacing: 1px;">
   Confirmed
</h2>
    <br>    <br>    <br>    <br>    <br>   <br>    
    <p>Merci pour votre commande !</p>

            `;
            
            // Replace form with customer info
            formClone.outerHTML = customerInfoHTML;
        }
        
        // Create red confirmation stamp
        const stamp = document.createElement('div');
        stamp.style.position = 'fixed';
        stamp.style.bottom = '50px';
        stamp.style.right = '50px';
        stamp.style.zIndex = '9999';
        stamp.innerHTML = `
            <div style="
                transform: rotate(-15deg);
                text-align: center;
                opacity: 0.9;
            ">
                <div style="
                    color: #ff0000;
                    font-size: 24px;
                    font-weight: bold;
                    border: 3px solid #ff0000;
                    border-radius: 50%;
                    width: 150px;
                    height: 150px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto;
                    font-family: 'Courier New', monospace;
                    background-color: rgba(255,255,255,0.8);
                    text-transform: uppercase;
                ">
                    CONFIRMÉ
                </div>
                <div style="
                    color: #ff0000;
                    font-size: 14px;
                    margin-top: 8px;
                    font-weight: bold;
                ">
                    Cachet officiel
                </div>
                <div style="
                    color: #ff0000;
                    font-size: 12px;
                    margin-top: 5px;
                ">
                    ${new Date().toLocaleDateString('fr-FR')}
                </div>
            </div>
        `;
        clone.appendChild(stamp);
        
        // PDF options
        const options = {
            margin: [15, 15, 15, 15], // Top, Right, Bottom, Left (in mm)
            filename: `facture_${new Date().toISOString().slice(0,10)}.pdf`,
            image: { 
                type: 'jpeg', 
                quality: 0.98 
            },
            html2canvas: { 
                scale: 2,
                scrollY: 0,
                useCORS: true,
                allowTaint: true,
                letterRendering: true
            },
            jsPDF: { 
                unit: 'mm', 
                format: 'a4',
                orientation: 'portrait'
            }
        };
        
        // Generate PDF
        html2pdf()
            .from(clone)
            .set(options)
            .save()
            .then(() => {
                showToast('PDF généré avec cachet de confirmation!', 'success');
            })
            .catch(err => {
                console.error('Erreur génération PDF:', err);
                showToast('Erreur lors de la génération du PDF', 'error');
            })
            .finally(() => {
                // Re-enable button
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-file-pdf"></i> Imprimer facture PDF';
            });
    });


    
    
</script>
</body>
</html>