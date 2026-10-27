<?php
require_once 'config.php';
$conn->set_charset('utf8mb4');
?>
<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BeautyShop</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f8f5f5;
    color: #222;
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: white;
}
.logo {
    font-size: 26px;
    font-weight: bold;
}
#searchInput {
    padding: 10px;
    max-width: 250px;
    width: 100%;
    box-sizing: border-box;
}
.nav-bar {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    background: #444;
}
.nav-bar a {
    color: white;
    text-decoration: none;
    padding: 15px 20px;
}
.nav-bar a:hover {
    background: #575757;
}
.uvod {
    text-align: center;
    padding: 20px 10px;
}
.produkty-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
}
.produkt {
    box-sizing: border-box;
    width: 250px;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    background: white;
}
.produkt img {
    max-width: 100%;
    width: 150px;
    height: 150px;
    object-fit: contain;
}
.produkt h3 {
    font-size: 18px;
}
.produkt p {
    font-size: 15px;
    overflow-wrap: anywhere;
}
.produkt button {
    padding: 10px 20px;
    background: green;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.produkt button:hover {
    background: darkgreen;
}
#kosikOkno {
    position: fixed;
    top: 10%;
    right: 5%;
    width: 320px;
    max-width: 85%;
    max-height: 75vh;
    overflow-y: auto;
    background: white;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,.3);
    z-index: 1000;
}
#kosikOkno button {
    margin: 5px;
    padding: 8px;
    cursor: pointer;
}
@media (max-width: 600px) {
    .header {
        flex-direction: column;
    }
    .produkt {
        width: 100%;
        max-width: 320px;
    }
}
</style>
</head>

<body>
<header class="header">
    <div class="logo">BeautyShop</div>
    <input type="text" id="searchInput" placeholder="Hledat produkt...">
</header>

<nav class="nav-bar">
    <a href="#" onclick="zobrazitVsechno(); return false;">Všechno</a>
    <a href="#" onclick="zobrazitKategorii('kosmetika'); return false;">Kosmetika</a>
    <a href="#" onclick="zobrazitKategorii('parfemy'); return false;">Parfémy</a>
    <a href="#" onclick="zobrazitKategorii('pece'); return false;">Péče o pleť</a>
    <a href="#" onclick="zobrazitKosik(); return false;">Košík</a>
</nav>

<section class="uvod">
    <h1>BeautyShop</h1>
    <p>Vítejte v našem obchodě s kosmetikou a parfémy!</p>
    <p>Vše, co potřebujete pro krásu, na jednom místě.</p>
</section>

<div class="produkty-container" id="produkty">
<?php
$sql = "SELECT id, name, price, image, description
        FROM products
        ORDER BY id DESC";

$vysledky = $conn->query($sql);

if ($vysledky && $vysledky->num_rows > 0):
    while ($produkt = $vysledky->fetch_assoc()):
        $nazev = (string)$produkt['name'];
        $cena = (float)$produkt['price'];
        $obrazek = (string)($produkt['image'] ?? '');
        $popis = (string)($produkt['description'] ?? '');
?>
    <div class="produkt" data-kategorie="kosmetika">

        <?php if ($obrazek !== ''): ?>
        <img
            src="<?= htmlspecialchars($obrazek, ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($nazev, ENT_QUOTES, 'UTF-8') ?>"
        >
        <?php endif; ?>

        <h3><?= htmlspecialchars($nazev, ENT_QUOTES, 'UTF-8') ?></h3>

        <p><strong>Cena:</strong>
            <?= number_format($cena, 2, ',', ' ') ?> Kč
        </p>

        <?php if ($popis !== ''): ?>
        <p><?= nl2br(htmlspecialchars($popis, ENT_QUOTES, 'UTF-8')) ?></p>
        <?php endif; ?>

        <button
            type="button"
            class="koupit-btn"
            data-name="<?= htmlspecialchars($nazev, ENT_QUOTES, 'UTF-8') ?>"
            data-price="<?= $cena ?>"
        >Koupit</button>
    </div>
<?php
    endwhile;
else:
?>
    <p>Zatím nejsou přidány žádné produkty.</p>
<?php endif; ?>
</div>

<script>
let kosik = [];
let celkovaCena = 0;

async function pridatDoKosika(nazev, cena) {
    try {
        const response = await fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nazev: nazev,
                cena: Number(cena)
            })
        });

        const data = await response.json();

        if (!response.ok || !data.success) {
            alert('Produkt se nepodařilo přidat do košíku.');
            return;
        }

        kosik.push({
            nazev: nazev,
            cena: Number(cena)
        });

        celkovaCena += Number(cena);
        alert(nazev + ' byl přidán do košíku.');
    } catch (error) {
        console.error(error);
        alert('Nepodařilo se spojit se serverem.');
    }
}

document.querySelectorAll('.koupit-btn').forEach(button => {
    button.addEventListener('click', function() {
        pridatDoKosika(
            this.dataset.name,
            Number(this.dataset.price)
        );
    });
});

function zobrazitKategorii(kategorie) {
    document.querySelectorAll('.produkt').forEach(produkt => {
        produkt.style.display =
            produkt.dataset.kategorie === kategorie ? 'block' : 'none';
    });
}

function zobrazitVsechno() {
    document.querySelectorAll('.produkt').forEach(produkt => {
        produkt.style.display = 'block';
    });
    hledatProdukt();
}

function hledatProdukt() {
    const hledanyText = document.getElementById('searchInput')
        .value.toLowerCase();

    document.querySelectorAll('.produkt').forEach(produkt => {
        const nazev = produkt.querySelector('h3')
            .textContent.toLowerCase();

        produkt.style.display =
            nazev.includes(hledanyText) ? 'block' : 'none';
    });
}

document.getElementById('searchInput')
    .addEventListener('input', hledatProdukt);

function zavritKosik() {
    const okno = document.getElementById('kosikOkno');
    if (okno) {
        okno.remove();
    }
}

function zobrazitKosik() {
    zavritKosik();

    const okno = document.createElement('div');
    okno.id = 'kosikOkno';

    const nadpis = document.createElement('h3');
    nadpis.textContent = 'Košík';
    okno.appendChild(nadpis);

    if (kosik.length === 0) {
        const prazdny = document.createElement('p');
        prazdny.textContent = 'Košík je prázdný.';
        okno.appendChild(prazdny);
    } else {
        const seznam = document.createElement('ul');

        kosik.forEach((produkt, index) => {
            const polozka = document.createElement('li');
            polozka.appendChild(document.createTextNode(
                produkt.nazev + ' - ' + produkt.cena + ' Kč '
            ));

            const odebrat = document.createElement('button');
            odebrat.textContent = 'Odstranit';
            odebrat.addEventListener('click', () => {
                kosik.splice(index, 1);
                celkovaCena = kosik.reduce(
                    (suma, p) => suma + p.cena, 0
                );
                zobrazitKosik();
            });

            polozka.appendChild(odebrat);
            seznam.appendChild(polozka);
        });

        okno.appendChild(seznam);

        const soucet = document.createElement('p');
        soucet.textContent = 'Celková cena: ' +
            celkovaCena.toFixed(2) + ' Kč';
        okno.appendChild(soucet);

        const objednat = document.createElement('button');
        objednat.textContent = 'Objednat';
        objednat.addEventListener('click', () => {
            window.location.href = 'kosik.php';
        });
        okno.appendChild(objednat);
    }

    const vymazat = document.createElement('button');
    vymazat.textContent = 'Vymazat celý košík';
    vymazat.addEventListener('click', vymazatKosik);
    okno.appendChild(vymazat);

    const zavrit = document.createElement('button');
    zavrit.textContent = 'Zavřít';
    zavrit.addEventListener('click', zavritKosik);
    okno.appendChild(zavrit);

    document.body.appendChild(okno);
}

async function vymazatKosik() {
    try {
        const response = await fetch('clear_cart.php', {
            method: 'POST'
        });

        if (!response.ok) {
            alert('Košík se nepodařilo vymazat na serveru.');
            return;
        }

        kosik = [];
        celkovaCena = 0;
        zobrazitKosik();
    } catch (error) {
        console.error(error);
        alert('Nepodařilo se spojit se serverem.');
    }
}
</script>

</body>
</html>
