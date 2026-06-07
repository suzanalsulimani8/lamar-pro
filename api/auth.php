<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit; }

// كلمة سر الإدارة — غيّرها بعد الرفع
define('ADMIN_PASSWORD', 'Lamar@2026');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode(['logged_in' => !empty($_SESSION['admin_logged_in'])]);

} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $pass  = $input['password'] ?? '';

    if ($pass === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        echo json_encode(['success' => true]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'كلمة السر غير صحيحة']);
    }

} elseif ($method === 'DELETE') {
    session_destroy();
    echo json_encode(['success' => true]);
}
?>
