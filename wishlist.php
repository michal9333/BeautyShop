<?php
session_start();
include "config.php";

// Kontrola, zda je uživatel přihlášen
if (!isset($_SESSION['user'])) {
    die("Chyba: Nejste přihlášeni.");
}

// Získání ID produktu a uživatele
$product = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = (int)$_SESSION['user'];

// Kontrola, zda bylo ID produktu předáno
if ($product === 0) {
    die("Chyba: Neplatné ID produktu.");
}

// Přidání produktu do wishlistu pomocí připraveného dotazu
$stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user, $product);

if ($stmt->execute()) {
    echo "Produkt byl přidán do oblíbených!";
} else {
    echo "Chyba při přidávání produktu do oblíbených.";
}
?>