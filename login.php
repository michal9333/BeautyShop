<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beautyshop";

// Vytvoření připojení
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeautyShop</title>
    <style>
        /* Základní styl pro produkty */
        .produkty-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .produkt {
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            background-color: white;
            color: black;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .produkt:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .produkt img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .produkt h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .produkt p {
            font-size: 16px;
            margin: 5px 0;
        }

        .produkt button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .produkt button:hover {
            background-color: darkgreen;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #333;
            color: white;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .header input {
            padding: 5px;
            font-size: 16px;
            max-width: 300px;
        }

        .nav-bar {
            display: flex;
            justify-content: center;
            background-color: #444;
            padding: 10px 0;
        }

        .nav-bar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
        }

        .nav-bar a:hover {
            background-color: #575757;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">BeautyShop</div>
        <input type="text" id="searchInput" placeholder="Hledat produkt..." onkeyup="hledatProdukt()">
    </header>

    <!-- Navigační lišta -->
    <div class="nav-bar">
        <a href="#" onclick="zobrazitKategorii('kosmetika')">Kosmetika</a>
        <a href="#" onclick="zobrazitKategorii('parfemy')">Parfémy</a>
        <a href="#" onclick="zobrazitKategorii('pece')">Péče o pleť</a>
        <a href="#" onclick="zobrazitKosik()">Košík</a>
    </div>

    <center>
        <h1>BeautyShop</h1>
        <p>Vítejte v našem obchodě s kosmetikou a parfémy!</p>
        <p>Vše, co potřebujete pro krásu, na jednom místě.</p>
    </center>

    <div class="produkty-container" id="produkty">
        <!-- Produkty -->
        <div class="produkt" data-kategorie="kosmetika">
            <img src="https://via.placeholder.com/250" alt="Kosmetický produkt">
            <h3>Krém na obličej</h3>
            <p><strong>Cena:</strong> 299 Kč</p>
            <button onclick="pridatDoKosika('Krém na obličej', 299)">Koupit</button>
        </div>
        <div class="produkt" data-kategorie="parfemy">
            <img src="https://via.placeholder.com/250" alt="Parfém">
            <h3>Luxusní parfém</h3>
            <p><strong>Cena:</strong> 999 Kč</p>
            <button onclick="pridatDoKosika('Luxusní parfém', 999)">Koupit</button>
        </div>
        <div class="produkt" data-kategorie="pece">
            <img src="https://via.placeholder.com/250" alt="Péče o pleť">
            <h3>Sérum na pleť</h3>
            <p><strong>Cena:</strong> 499 Kč</p>
            <button onclick="pridatDoKosika('Sérum na pleť', 499)">Koupit</button>
        </div>
    </div>

    <script>
        let kosik = [];
        let celkovaCena = 0;

        function pridatDoKosika(nazev, cena) {
            kosik.push({ nazev, cena });
            celkovaCena += cena;
            alert(`${nazev} byl přidán do košíku.`);
        }

        function zobrazitKategorii(kategorie) {
            const produkty = document.querySelectorAll('.produkt');
            produkty.forEach(produkt => {
                if (produkt.getAttribute('data-kategorie') === kategorie) {
                    produkt.style.display = 'block';
                } else {
                    produkt.style.display = 'none';
                }
            });
        }

        function hledatProdukt() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const produkty = document.querySelectorAll('.produkt');
            produkty.forEach(produkt => {
                const nazev = produkt.querySelector('h3').textContent.toLowerCase();
                produkt.style.display = nazev.includes(input) ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>