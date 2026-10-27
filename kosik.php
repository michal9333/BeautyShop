<?php 
session_start(); // Správné inicializování session
?>
<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <title>Objednávka</title>
        <link rel="stylesheet" href="styl.css"> <!-- Opravený odkaz na styl -->
    </head>
    <body>
        <h1>Objednávkový formulář</h1>

        <?php
        // Kontrola, zda je košík inicializován a obsahuje produkty
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<p>Košík je prázdný. Nelze vytvořit objednávku.</p>";
            exit;
        }

        // Zobrazení obsahu košíku
        echo "<h2>Obsah košíku:</h2>";
        echo "<ul>";
        foreach ($_SESSION['cart'] as $product) {
            echo "<li>" . htmlspecialchars($product['nazev']) . " - " . htmlspecialchars($product['cena']) . " Kč</li>";
        }
        echo "</ul>";

        // Výpočet celkové ceny
        $celkovaCena = array_sum(array_column($_SESSION['cart'], 'cena'));
        echo "<p><strong>Celková cena:</strong> $celkovaCena Kč</p>";
        ?>

        <!-- Formulář pro objednávku -->
        <form action="process_order.php" method="POST">
            <label for="jmeno">Jméno:</label>
            <input type="text" id="jmeno" name="jmeno" required><br><br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="adresa">Adresa:</label>
            <textarea id="adresa" name="adresa" required></textarea><br><br>

            <label for="psc">PSČ:</label>
            <input type="text" id="psc" name="psc" required><br><br>

            <button type="submit">Odeslat objednávku</button>
        </form>
    </body>
</html>