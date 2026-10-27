<?php
session_start();

// Kontrola, zda je košík inicializován
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h1>Košík je prázdný.</h1>";
    exit;
}

echo "<h1>Košík</h1>";
echo "<ul>";

foreach ($_SESSION['cart'] as $product) {
    echo "<li>" . htmlspecialchars($product['nazev']) . " - " . htmlspecialchars($product['cena']) . " Kč</li>";
}

echo "</ul>";

$celkovaCena = array_sum(array_column($_SESSION['cart'], 'cena'));
echo "<p><strong>Celková cena:</strong> $celkovaCena Kč</p>";
echo '<form action="checkout.php" method="post">
    <button type="submit">objednat</button>
</form>';
?>