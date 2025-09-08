<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

   
   <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: #1a202c;
            color: #cbd5e0;
            width: 250px;
            padding-top: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 10;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #4a5568;
            margin-bottom: 20px;
        }

        .sidebar-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: #cbd5e0;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: #2d3748;
            border-left-color: #4299e1;
            color: #fff;
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

      .main-content {
    flex-grow: 1;
    padding: 20px; /* Keep padding for overall content spacing, or reduce if preferred */
    display: flex;
    flex-direction: column;
    margin-left: 250px;
    transition: margin-left 0.3s ease;
}

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .dashboard-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .dashboard-header .logout-button {
            background-color: #dc2626;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .dashboard-header .logout-button:hover {
            background-color: #b91c1c;
        }

        .announcement-area {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .announcement-slider {
            display: flex;
            animation: scroll 15s linear infinite;
        }

        .announcement-item {
            flex: 0 0 auto;
            margin-right: 20px;
        }

        .announcement-item img {
            max-height: 150px;
            border-radius: 5px;
        }

        @keyframes scroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-100%); }
        }

        .content-area {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .content-area h3 {
            font-size: 1.5rem;
            color: #4a5568;
            margin-bottom: 20px;
        }

        .products-container {
            display: flex;
            flex-direction: column;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .products-container h2 {
            margin-bottom: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
            border-radius: 25px;
            border: 1px solid rgb(245, 148, 83);
            padding: 5px 10px;
            width: 300px;
            transition: border-color 0.3s ease;
        }

        .search-icon {
            margin-right: 10px;
            color: rgb(245, 148, 83);
        }

        #searchInput {
            padding: 8px 0;
            border: none;
            font-size: 1em;
            width: 100%;
            outline: none;
        }

        #searchInput::placeholder {
            color: #cbd5e0;
        }

        .search-container:focus-within {
            border-color: rgb(245, 148, 83);
            box-shadow: 0 0 15px rgb(245, 148, 83);
        }

        .product-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 0;
        }

        .product-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-card:last-child {
            border-bottom: none;
        }

        .product-card img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
            margin-right: 10px;
            object-fit: cover;
        }

        .product-card-info {
            flex-grow: 1;
            margin-right: 10px;
        }

        .product-card-info h3 {
            margin-top: 0;
            margin-bottom: 3px;
            font-size: 1em;
            color: #2d3748;
        }

        .product-card-info p {
            color: #4a5568;
            margin-bottom: 0;
            font-size: 0.8em;
        }

        .product-actions {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }

        .product-actions a {
            color: #FF9800;
            font-size: 0.9em;
            text-decoration: none;
            transition: color 0.3s ease;
            padding: 2px;
            margin-left: 0;
        }

        .product-actions a:hover {
            color: #FFA726;
        }

        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                margin-bottom: 20px;
            }
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            .product-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .product-card img {
                width: 80px;
                margin-bottom: 10px;
                margin-right: 0;
            }
            .products-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-container {
                width: 100%;
                margin-left: 0;
                margin-top: 10px;
            }
        }

        .edit-form-container {
            margin-top: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 5px;
        }

        .edit-form-container h3 {
            font-size: 1.2rem;
            margin-top: 0;
            margin-bottom: 10px;
            color: #4a5568;
        }

        .edit-form-container div {
            margin-bottom: 10px;
        }

        .edit-form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #718096;
        }

        .edit-form-container input[type="text"],
        .edit-form-container input[type="file"],
        .edit-form-container input[type="number"]{
            width: 100%;
            padding: 8px;
            border: 1px solid #cbd5e0;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .edit-form-container button {
            background-color: #4299e1;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        .edit-form-container button:hover {
            background-color: #2b6cb0;
        }

        .edit-form-container .cancel-edit-btn {
            background-color: #cbd5e0;
            color: #2d3748;
        }

        .edit-form-container .cancel-edit-btn:hover {
            background-color: #a0aec0;
        }

        #add-product-form-container {
            display: none;
            margin-top: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        #add-product-form-container h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        #add-product-form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #add-product-form-container form div {
            display: flex;
            flex-direction: column;
        }

        #add-product-form-container form label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #7f8c8d;
        }

        #add-product-form-container form input {
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        #add-product-form-container form input:focus {
            outline: none;
            border-color: #3498db;
        }

        #add-product-form-container form button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            color: white;
            margin-top: 10px;
        }

        #add-product-form-container form button[type="submit"] {
            background-color: #2ecc71;
        }

        #add-product-form-container form button[type="submit"]:hover {
            background-color: #27ae60;
        }

        #add-product-form-container form button[type="button"] {
            background-color: #e74c3c;
            color: white;
        }

        #add-product-form-container form button[type="button"]:hover {
            background-color: #c0392b;
        }

        /* Styles pour les conteneurs de formulaires (ajout et édition) - Réduit */
    .form-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        margin: 20px auto;
        max-width: 500px; /* Réduction significative de la largeur maximale */
        width: 95%;
    }

    .form-container h3 {
        font-size: 1.6rem;
        color: #444;
        margin-bottom: 25px;
        text-align: center;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #666;
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group textarea {
        width: calc(100% - 12px);
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        color: #333;
        box-sizing: border-box;
        transition: border-color 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.2);
    }

    .form-group textarea {
        min-height: 100px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end; /* Alignement des boutons à droite */
        gap: 10px;
        margin-top: 25px;
    }

    .form-actions button {
        padding: 8px 16px; /* Réduction de la taille des boutons */
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .form-actions button[type="submit"] {
        background-color: #007bff; /* Bleu primaire */
        color: white;
    }

    .form-actions button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .form-actions button[type="button"] {
        background-color: #6c757d; /* Gris secondaire */
        color: white;
    }

    .form-actions button[type="button"]:hover {
        background-color: #545b62;
    }

    /* Styles spécifiques aux formulaires */
    #add-product-form-container {
        /* Conserver display: none; */
    }

    .edit-form-container {
        /* Conserver display: none; */
        margin-top: 15px;
    }

       .messenger-messages-container {
            margin-top: 20px;
            border: 1px solid #ced4da;
            padding: 15px;
            border-radius: 5px;
        }

        .messenger-messages-container h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .messenger-messages-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .messenger-messages-container th, .messenger-messages-container td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        .messenger-messages-container th {
            background-color: #f2f2f2;
        }

        .messenger-messages-container tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

         .messenger-messages-container .actions {
        white-space: nowrap; /* Empêche le texte de passer à la ligne */
    }

    .messenger-messages-container .actions a {
        margin-right: 10px; /* Ajoute un peu d'espace entre les actions */
        text-decoration: none; /* Supprime le soulignement par défaut des liens */
    }

    .messenger-messages-container .actions i {
        margin-right: 5px; /* Ajoute un peu d'espace entre l'icône et le texte */
    }




  /* Styles for analytics table - NOUVEAU DESIGN */
.analytics-container {
    background-color: #fff;
    padding: 25px; /* Légèrement plus de padding pour l'aération */
    border-radius: 10px; /* Bords légèrement plus arrondis */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Ombre plus douce et plus prononcée */
    margin-top: 0; /* Important pour que ça reste en haut */
    margin-bottom: 30px; /* Plus d'espace sous le conteneur */
}

.analytics-container h3 {
    font-size: 1.8rem; /* Titre un peu plus grand */
    color: #2c3e50; /* Couleur de texte plus foncée pour le contraste */
    margin-bottom: 25px; /* Plus d'espace sous le titre */
    text-align: center; /* Centrer le titre */
    font-weight: 700; /* Plus gras */
}

.analytics-container table {
    width: 100%;
    border-collapse: separate; /* Permet les bordures arrondies sur les cellules */
    border-spacing: 0; /* Supprime l'espace entre les cellules */
    margin-top: 0; /* Aucun espace supplémentaire ici */
}

.analytics-container th,
.analytics-container td {
    padding: 15px 20px; /* Plus de padding pour l'aération des cellules */
    text-align: left;
    border-bottom: 1px solid #e0e0e0; /* Lignes horizontales fines */
}

.analytics-container th {
    background-color: #f5f5f5; /* Fond très clair pour l'en-tête */
    font-weight: 700; /* Texte en gras pour l'en-tête */
    color: #4a4a4a; /* Couleur de texte légèrement plus foncée */
    text-transform: uppercase; /* Met le texte en majuscules */
    font-size: 0.9em; /* Taille de police légèrement plus petite pour l'en-tête */
}

/* Styles pour les coins arrondis de l'en-tête */
.analytics-container th:first-child {
    border-top-left-radius: 8px;
}
.analytics-container th:last-child {
    border-top-right-radius: 8px;
}

.analytics-container td {
    background-color: #ffffff; /* Fond blanc pur pour les cellules de données */
    color: #333; /* Couleur de texte sombre pour une bonne lisibilité */
}

.analytics-container tr:last-child td {
    border-bottom: none; /* Pas de bordure sous la dernière ligne */
}

/* Effet de survol sur les lignes du tableau */
.analytics-container tbody tr:hover {
    background-color: #f9f9f9; /* Changement de couleur très léger au survol */
    cursor: pointer; /* Indique que la ligne est interactive (si applicable) */
    transition: background-color 0.2s ease; /* Transition douce */
}

/* Styles pour l'image dans le tableau */
.analytics-container td img {
    border-radius: 4px; /* Bords légèrement arrondis pour l'image */
    border: 1px solid #eee; /* Petite bordure subtile autour de l'image */
    box-shadow: 0 1px 3px rgba(0,0,0,0.05); /* Petite ombre pour l'image */
}

/* Pour les colonnes numériques, aligner à droite */
.analytics-container th:nth-child(1), /* ID Pub */
.analytics-container td:nth-child(1),
.analytics-container th:nth-child(2), /* ID Produit */
.analytics-container td:nth-child(2) {
    text-align: center; /* Centrer les IDs */
}
/* Styles pour la colonne d'actions */
.analytics-container th:last-child,
.analytics-container td:last-child {
    text-align: center; /* Centrer les boutons d'action */
}

.action-buttons {
    white-space: nowrap; /* Empêche les boutons de passer à la ligne */
}

.action-button {
    display: inline-block; /* Pour un bon espacement et alignement */
    margin: 0 5px; /* Espacement entre les boutons */
    font-size: 1.1em; /* Taille de l'icône */
    padding: 6px; /* Espace autour de l'icône */
    border-radius: 5px; /* Bords légèrement arrondis */
    transition: background-color 0.2s ease, transform 0.2s ease; /* Transitions douces */
    text-decoration: none; /* Supprime le soulignement des liens */
}

.action-button i {
    pointer-events: none; /* S'assure que le clic passe au parent a */
}

.edit-button {
    color: #3498db; /* Couleur bleue pour modifier */
    background-color: #e8f5fe; /* Fond très clair */
}

.edit-button:hover {
    background-color: #d1ecfa; /* Fond plus foncé au survol */
    transform: translateY(-1px); /* Léger effet de soulèvement */
}

.delete-button {
    color: #e74c3c; /* Couleur rouge pour supprimer */
    background-color: #fcebeb; /* Fond très clair */
}

.delete-button:hover {
    background-color: #f8d7da; /* Fond plus foncé au survol */
    transform: translateY(-1px); /* Léger effet de soulèvement */
}

/* Ajustement des coins arrondis pour la dernière colonne */
.analytics-container th:last-child {
    border-top-right-radius: 8px; /* Assure que le coin est bien arrondi */
}

/* Si vous voulez que les coins inférieurs du tableau soient aussi arrondis */
.analytics-container tr:last-child td:first-child {
    border-bottom-left-radius: 8px;
}
.analytics-container tr:last-child td:last-child {
    border-bottom-right-radius: 8px;
}



/*   Analytics Publicite style  */
 /* Basic styling for editable fields feedback */
    .editable-cell input, .editable-cell textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ccc;
        padding: 5px;
        margin: -5px; /* Adjust to fit well within table cell padding */
    }
    .editable-cell.editing {
        background-color: #f0f8ff; /* Light blue background to indicate editing */
    }

    </style>
</head>
<body>



 <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Admin Panel</h1>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php?action=adminDashboard" class="<?php if ($_GET['action'] === 'adminDashboard' || !isset($_GET['action'])): ?>active<?php endif; ?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a href="index.php?action=ShowAd"><i class="fas fa-box-open"></i>Home</a></li>
                <li><a href="#" id="add-product-link"><i class="fas fa-plus-circle"></i>Add Product</a></li>
                <li><a href="index.php?action=showMessengerMessages" class="<?php if ($_GET['action'] === 'showMessengerMessages'): ?>active<?php endif; ?>"><i class="fas fa-users"></i>Users</a></li>
            <li><a href="index.php?action=productAnalytics" class="<?php if (($current_action ?? '') === 'productAnalytics'): ?>active<?php endif; ?>"><i class="fas fa-chart-bar"></i>Analytics</a></li>
                <li><a href="#"><i class="fas fa-cog"></i>Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="dashboard-header">
                <h2>Dashboard</h2>
                <a href="index.php?action=adminLogout" class="logout-button"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>



            







         <div class="content-wrapper">
    <div class="container-fluid">
        <?php if (isset($success)): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (($current_action ?? '') === 'productAnalytics'): ?>
            <div id="product-analytics-container" class="analytics-container">
                <h3>Product Publicité Analytics</h3>
                <?php if (!empty($publiciteProducts) && is_array($publiciteProducts)): ?>
                    <table class="table" id="publicite-products-table">
                        <thead>
                            <tr>
                                <th>ID Pub</th>
                                <th>ID Produit</th>
                                <th>Nom Produit</th>
                                <th>Image</th>
                                <th>Taille</th>
                                <th>Couleur</th>
                                <th>Description Générale</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($publiciteProducts as $productAnalytics): ?>
                                <tr data-id-pub="<?= htmlspecialchars($productAnalytics['id_pub'] ?? '') ?>">
                                    <td><?= htmlspecialchars($productAnalytics['id_pub'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($productAnalytics['id_produit'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($productAnalytics['product_name'] ?? '') ?></td>
                                    <td>
                                        <?php if (!empty($productAnalytics['product_image'])): ?>
                                            <img src="<?= htmlspecialchars($productAnalytics['product_image']) ?>" alt="<?= htmlspecialchars($productAnalytics['product_name'] ?? '') ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            Pas d'image
                                        <?php endif; ?>
                                    </td>
                                    <td class="editable-cell" data-field="taille"><?= htmlspecialchars($productAnalytics['taille'] ?? '') ?></td>
                                    <td class="editable-cell" data-field="couleur"><?= htmlspecialchars($productAnalytics['couleur'] ?? '') ?></td>
                                    <td class="editable-cell" data-field="description_generale"><?= nl2br(htmlspecialchars($productAnalytics['description_generale'] ?? '')) ?></td>
                                    <td class="action-buttons">
                                     

                                        <a href="#" class="action-button edit-publicite-button" data-id-pub="<?= htmlspecialchars($productAnalytics['id_pub'] ?? '') ?>" title="Modifier Publicité">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <button class="action-button save-publicite-button btn btn-sm btn-success" style="display:none;" data-id-pub="<?= htmlspecialchars($productAnalytics['id_pub'] ?? '') ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="action-button cancel-publicite-button btn btn-sm btn-secondary" style="display:none;" data-id-pub="<?= htmlspecialchars($productAnalytics['id_pub'] ?? '') ?>">
                                            <i class="fas fa-times"></i>
                                        </button>

                                        <a href="index.php?action=deletePubliciteProduct&id=<?= htmlspecialchars($productAnalytics['id_pub'] ?? '') ?>" title="Supprimer Publicité" class="action-button delete-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publicité ?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune donnée de publicité produit trouvée.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>









            <?php if ($_GET['action'] === 'adminDashboard' || !isset($_GET['action'])): ?>
                <div class="announcement-area">
                    <div class="announcement-slider">
                        <?php
                        $imageDirectory = '../public/images/';
                        if (is_dir($imageDirectory)) {
                            $imageFiles = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                            if (!empty($imageFiles)) {
                                foreach ($imageFiles as $imageFile) {
                                    $imageName = basename($imageFile);
                                    echo '<div class="announcement-item">';
                                    echo '<img src="../public/images/' . htmlspecialchars($imageName) . '" alt="' . htmlspecialchars($imageName) . '">';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Aucune image de produit trouvée dans le dossier images.</p>';
                            }
                        } else {
                            echo '<p>Le dossier images n\'existe pas.</p>';
                        }
                        ?>
                    </div>
                </div>

                <div class="products-container">
                    <div class="products-header">
                        <h2>All Products</h2>
                        <div class="search-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" placeholder="Rechercher un produit...">
                        </div>
                    </div>
                    <div class="product-list">
                        <?php if (!empty($products) && is_array($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="product-card">
                                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                                   <div class="product-card-info">
                                        <h3><?= htmlspecialchars($product['name']); ?></h3>
                                        <p>Price: <?= htmlspecialchars($product['price']); ?> €</p>
                                        <p class="product-description"><?= ($product['description']); ?></p>
                                    </div>
                                    <div class="product-actions">
                                        <a href="#" class="edit-product-btn" data-product-id="<?= htmlspecialchars($product['id']); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="delete-product" data-product-id="<?= htmlspecialchars($product['id']); ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>

                                   <div class="edit-form-container" id="edit-form-<?= htmlspecialchars($product['id']); ?>" style="display: none;">
                                        <h3>Modifier le produit</h3>
                                        <form action="index.php?action=updateProduct" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">
                                            <div class="form-group">
                                                <label for="name-<?= htmlspecialchars($product['id']); ?>">Nom:</label>
                                                <input type="text" id="name-<?= htmlspecialchars($product['id']); ?>" name="name" value="<?= htmlspecialchars($product['name']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="price-<?= htmlspecialchars($product['id']); ?>">Prix:</label>
                                                <input type="number" id="price-<?= htmlspecialchars($product['id']); ?>" name="price" value="<?= htmlspecialchars($product['price']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="description-<?= htmlspecialchars($product['id']); ?>">Description:</label>
                                                <textarea id="description-<?= htmlspecialchars($product['id']); ?>" name="description"><?= htmlspecialchars($product['description'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="qtt-<?= htmlspecialchars($product['id']); ?>">Quantité:</label>
                                                <input type="number" id="qtt-<?= htmlspecialchars($product['id']); ?>" name="qtt" value="<?= htmlspecialchars($product['qtt']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="image-<?= htmlspecialchars($product['id']); ?>">Image (laisser vide pour ne pas changer):</label>
                                                <input type="file" id="image-<?= htmlspecialchars($product['id']); ?>" name="image">
                                            </div>
                                            <button type="submit">Enregistrer les modifications</button>
                                            <button type="button" class="cancel-edit-btn" data-product-id="<?= htmlspecialchars($product['id']); ?>">Annuler</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No products available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

 
            



            <?php if ($_GET['action'] === 'showMessengerMessages'): ?>
                <div class="messenger-messages-container">
                    <h3>Messages des Utilisateurs</h3>
                    <?php if (!empty($messages)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <tr id="message-row-<?php echo htmlspecialchars($message['id']); ?>">
                                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                                        <td><?php echo htmlspecialchars($message['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                                        <td><?php echo htmlspecialchars($message['message']); ?></td>
                                        <td><?php echo isset($message['created_at']) ? htmlspecialchars($message['created_at']) : 'N/A'; ?></td>
                                       <td class="actions">
    <a href="#" class="delete-message-btn" data-message-id="<?php echo htmlspecialchars($message['id']); ?>">
        <i class="fas fa-trash-alt"></i> Supprimer
    </a>
    <a href="https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=<?php echo urlencode($message['email']); ?>" 
       target="_blank" 
       class="gmail-reply-btn">
        <i class="fas fa-reply"></i> Répondre
    </a>
</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Aucun message utilisateur pour le moment.</p>
                    <?php endif; ?>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const deleteMessageButtons = document.querySelectorAll('.delete-message-btn');

                        deleteMessageButtons.forEach(button => {
                            button.addEventListener('click', function(event) {
                                event.preventDefault();
                                const messageId = this.getAttribute('data-message-id');
                                if (confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
                                    fetch('index.php?action=deleteMessage', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: 'id=' + messageId
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            const messageRow = document.getElementById(`message-row-${messageId}`);
                                            if (messageRow) {
                                                messageRow.remove();
                                            }
                                        } else {
                                            alert('Erreur lors de la suppression du message.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Erreur de requête:', error);
                                        alert('Une erreur s\'est produite lors de la suppression du message.');
                                    });
                                }
                            });
                        });
                    });
                </script>
            <?php endif; ?>








            <div id="add-product-form-container" class="form-container">
                <h3>Add New Product</h3>
                <form action="index.php?action=addProduct" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="qtt">Quantity:</label>
                        <input type="number" id="qtt" name="qtt" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit">Confirm Add</button>
                        <button type="button" id="cancel-add-product">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    




    <script>
     document.addEventListener('DOMContentLoaded', function() {
    // 1. Gestion de l'ajout de produit (votre code original modifié)
    const addProductLink = document.getElementById('add-product-link');
    const addProductFormContainer = document.getElementById('add-product-form-container');
    const cancelAddProductButton = document.getElementById('cancel-add-product');
    
    // Sélection de tous les éléments à masquer quand on affiche le formulaire
    const sectionsToHide = [
        document.querySelector('.announcement-area'),
        document.querySelector('.products-container'),
        document.querySelector('.messenger-messages-container'),
        document.querySelector('.analytics-container')
    ].filter(el => el !== null); // Filtrer les éléments null
    
    addProductLink.addEventListener('click', function(event) {
        event.preventDefault();
        
        // Masquer toutes les sections
        sectionsToHide.forEach(section => {
            if (section) section.style.display = 'none';
        });
        
        // Afficher le formulaire
        addProductFormContainer.style.display = 'block';
    });

    cancelAddProductButton.addEventListener('click', function(event) {
        event.preventDefault();
        
        // Masquer le formulaire
        addProductFormContainer.style.display = 'none';
        
        // Réafficher le dashboard par défaut
        sectionsToHide.forEach(section => {
            if (section) section.style.display = 'block';
        });
    });

    // 2. Conserver tout votre code existant pour les autres fonctionnalités
    const deleteButtons = document.querySelectorAll('.delete-product');
    const editButtons = document.querySelectorAll('.edit-product-btn');
    const cancelEditButtons = document.querySelectorAll('.cancel-edit-btn');
    const editFormContainers = document.querySelectorAll('.edit-form-container');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.getAttribute('data-product-id');
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                fetch('index.php?action=deleteProduct', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + productId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const productCard = this.closest('.product-card');
                        if (productCard) {
                            productCard.remove();
                        }
                    } else {
                        alert('Erreur lors de la suppression du produit.');
                    }
                })
                .catch(error => {
                    console.error('Erreur de requête:', error);
                    alert('Une erreur s\'est produite.');
                });
            }
        });
    });

    editButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const editForm = document.getElementById(`edit-form-${productId}`);
            if (editForm) {
                editForm.style.display = 'block';
            }
        });
    });

    cancelEditButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.getAttribute('data-product-id');
            const editForm = document.getElementById(`edit-form-${productId}`);
            if (editForm) {
                editForm.style.display = 'none';
            }
        });
    });
});





document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('publicite-products-table');

    if (!table) return; // Exit if the table doesn't exist

    let currentEditingRow = null; // To keep track of which row is being edited
    let originalValues = {}; // To store original values for cancel

    // Function to put a row into edit mode
    function enableInlineEdit(row) {
        if (currentEditingRow && currentEditingRow !== row) {
            // If another row is being edited, revert it first
            cancelInlineEdit(currentEditingRow);
        }

        currentEditingRow = row;
        currentEditingRow.classList.add('editing');

        const cells = row.querySelectorAll('.editable-cell');
        originalValues = {};

        cells.forEach(cell => {
            const field = cell.dataset.field;
            let originalValue = cell.textContent.trim(); // For textarea, use innerText
            originalValues[field] = originalValue;

            let inputElement;
            if (field === 'description_generale') {
                inputElement = document.createElement('textarea');
                inputElement.value = originalValue.replace(/<br\s*\/?>/g, "\n"); // Convert <br> to newlines for textarea
                inputElement.rows = 3; // Make textarea reasonable size
            } else {
                inputElement = document.createElement('input');
                inputElement.type = 'text';
                inputElement.value = originalValue;
            }
            inputElement.name = field; // Important for form submission (even if it's AJAX)
            inputElement.classList.add('form-control'); // Add Bootstrap class for styling

            cell.innerHTML = ''; // Clear cell content
            cell.appendChild(inputElement);
        });

        // Toggle buttons
        row.querySelector('.edit-publicite-button').style.display = 'none';
        row.querySelector('.save-publicite-button').style.display = 'inline-block';
        row.querySelector('.cancel-publicite-button').style.display = 'inline-block';
        // Hide the general product edit button for this row if desired
        const generalEditButton = row.querySelector('.action-button.edit-button');
        if (generalEditButton) generalEditButton.style.display = 'none';
    }

    // Function to revert a row from edit mode
    function cancelInlineEdit(row) {
        if (!row) return; // Guard clause
        const cells = row.querySelectorAll('.editable-cell');
        cells.forEach(cell => {
            const field = cell.dataset.field;
            // Restore original value
            let valueToRestore = originalValues[field] || '';
            if (field === 'description_generale') {
                // If it was nl2br, revert newlines back to <br> for display
                valueToRestore = valueToRestore.replace(/\n/g, '<br>');
            }
            cell.innerHTML = valueToRestore;
        });

        row.classList.remove('editing');

        // Toggle buttons back
        row.querySelector('.edit-publicite-button').style.display = 'inline-block';
        row.querySelector('.save-publicite-button').style.display = 'none';
        row.querySelector('.cancel-publicite-button').style.display = 'none';
        const generalEditButton = row.querySelector('.action-button.edit-button');
        if (generalEditButton) generalEditButton.style.display = 'inline-block';

        currentEditingRow = null;
        originalValues = {}; // Clear stored values
    }

    // Event listener for all "edit-publicite-button" clicks
    table.addEventListener('click', function(event) {
        const editButton = event.target.closest('.edit-publicite-button');
        if (editButton) {
            event.preventDefault(); // Prevent default link behavior (e.g., navigating to #)
            const row = editButton.closest('tr');
            enableInlineEdit(row);
        }
    });

    // Event listener for all "cancel-publicite-button" clicks
    table.addEventListener('click', function(event) {
        const cancelButton = event.target.closest('.cancel-publicite-button');
        if (cancelButton) {
            event.preventDefault();
            const row = cancelButton.closest('tr');
            cancelInlineEdit(row);
        }
    });

    // Event listener for all "save-publicite-button" clicks
    table.addEventListener('click', function(event) {
        const saveButton = event.target.closest('.save-publicite-button');
        if (saveButton) {
            event.preventDefault();
            const row = saveButton.closest('tr');
            const idPub = row.dataset.idPub;

            const taille = row.querySelector('[data-field="taille"] input').value;
            const couleur = row.querySelector('[data-field="couleur"] input').value;
            const description_generale = row.querySelector('[data-field="description_generale"] textarea').value;

            // Create FormData object to send data
            const formData = new FormData();
            formData.append('id_pub', idPub);
            formData.append('taille', taille);
            formData.append('couleur', couleur);
            formData.append('description_generale', description_generale);

            fetch('index.php?action=updatePubliciteProduct', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the displayed values in the cells
                    row.querySelector('[data-field="taille"]').textContent = taille;
                    row.querySelector('[data-field="couleur"]').textContent = couleur;
                    // For description, replace newlines with <br> for display
                    row.querySelector('[data-field="description_generale"]').innerHTML = description_generale.replace(/\n/g, '<br>');

                    // Revert the row from edit mode
                    row.classList.remove('editing');
                    row.querySelector('.edit-publicite-button').style.display = 'inline-block';
                    row.querySelector('.save-publicite-button').style.display = 'none';
                    row.querySelector('.cancel-publicite-button').style.display = 'none';
                     const generalEditButton = row.querySelector('.action-button.edit-button');
                    if (generalEditButton) generalEditButton.style.display = 'inline-block';

                    currentEditingRow = null;
                    originalValues = {}; // Clear stored values

                    // Optional: Show a success message to the user
                    alert(data.message); // Or integrate into your existing message system
                } else {
                    alert('Erreur: ' + (data.error || 'Une erreur inconnue est survenue.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la communication avec le serveur.');
            });
        }
    });
});
    </script>
</body>
</html>
