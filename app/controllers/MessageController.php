<?php
namespace App\Controllers;

use App\Models\Message;

class MessageController extends Controller {

    public function submitMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? ''; // Changé de 'tel' à 'phone'
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';

            $messageModel = new Message();
            $success = $messageModel->saveMessage($name, $phone, $email, $message);

            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send message. Please try again.']);
            }
            exit;
        }
        // Si la requête n'est pas POST
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }
}