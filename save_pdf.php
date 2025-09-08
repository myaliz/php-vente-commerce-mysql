<?php
// save_pdf.php

// Vérifier les permissions du dossier
$targetDir = __DIR__ . '/public/admin_verifier/';

// Debug: Vérifier si le dossier existe
if (!file_exists($targetDir)) {
    if (!mkdir($targetDir, 0755, true)) {
        die(json_encode(['error' => 'Impossible de créer le dossier']));
    }
}

// Debug: Vérifier les permissions
if (!is_writable($targetDir)) {
    die(json_encode(['error' => 'Dossier non accessible en écriture']));
}

// Vérifier le fichier uploadé
if (!isset($_FILES['pdf'])) {
    die(json_encode(['error' => 'Aucun fichier reçu']));
}

// Générer un nom de fichier unique
$filename = 'facture_' . uniqid() . '.pdf';
$targetFile = $targetDir . $filename;

// Déplacer le fichier
if (move_uploaded_file($_FILES['pdf']['tmp_name'], $targetFile)) {
    echo json_encode(['success' => 'Fichier enregistré: ' . $filename]);
} else {
    // Debug: Afficher les erreurs d'upload
    $error = $_FILES['pdf']['error'];
    $uploadErrors = [
        0 => 'Aucune erreur',
        1 => 'Fichier trop volumineux',
        2 => 'Fichier trop volumineux',
        3 => 'Upload partiel',
        4 => 'Aucun fichier',
        6 => 'Dossier temporaire manquant',
        7 => 'Erreur d\'écriture',
        8 => 'Extension PHP bloquée'
    ];
    die(json_encode([
        'error' => 'Erreur d\'upload',
        'code' => $error,
        'message' => $uploadErrors[$error] ?? 'Erreur inconnue'
    ]));
}