<?php
echo "<pre>";
print_r($_SESSION['cart']);
echo "</pre>";
session_start();

// Kontrola, zda je košík inicializován a obsahuje produkty
if (empty($_SESSION['cart'])) {
    die("Košík je prázdný.");
}

// Kontrola, zda je uživatel přihlášen
if (!isset($_SESSION['user'])) {
    die("Uživatel není přihlášen.");
}

// Získání uživatele a obsahu košíku
$user = $_SESSION['user'];
$cart = $_SESSION['cart'];

// Vytvoření obsahu objednávky
$orderContent = "Objednávka:\n";
$orderContent .= "Uživatel: $user\n";
$orderContent .= "Produkty:\n";

foreach ($cart as $id => $product) {
    $orderContent .= "- " . htmlspecialchars($product['nazev']) . " - " . htmlspecialchars($product['cena']) . " Kč\n";
}

// Uložení objednávky do souboru
$file = 'orders.txt';
if (file_put_contents($file, $orderContent . "\n---\n", FILE_APPEND)) {
    // Vyprázdnění košíku
    unset($_SESSION['cart']);
    echo "Objednávka byla úspěšně vytvořena. Děkujeme za nákup!";
} else {
    echo "Chyba při ukládání objednávky. Zkuste to prosím znovu.";
}
?>