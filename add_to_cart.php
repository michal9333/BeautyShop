<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$data = json_decode(file_get_contents('php://input'), true);

if (
    isset($data['nazev'], $data['cena']) &&
    is_numeric($data['cena'])
) {
    $_SESSION['cart'][] = [
        'nazev' => trim($data['nazev']),
        'cena' => (float) $data['cena']
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Produkt byl přidán do košíku.'
    ]);
} else {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Neplatná data.'
    ]);
}