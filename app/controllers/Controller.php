<?php
namespace App\Controllers;

class Controller {
    // Ici tu peux ajouter des méthodes communes à tous les contrôleurs si besoin
   protected function render($viewName, $data = []) {
    // Extrait les variables du tableau $data
    extract($data);
    
    // Chemin vers le fichier de vue
    $viewPath = __DIR__ . '/../views/' . $viewName . '.php';
    
    if (file_exists($viewPath)) {
        require_once $viewPath;
    } else {
        throw new \Exception("La vue $viewName n'existe pas");
    }
}
}
