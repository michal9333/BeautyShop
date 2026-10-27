<?php
// Statické pole produktů
$products = [
    1 => [
        'name' => 'Produkt 1',
        'image' => 'product1.jpg',
        'description' => 'Popis produktu 1.',
        'price' => 100
    ],
    2 => [
        'name' => 'Produkt 2',
        'image' => 'product2.jpg',
        'description' => 'Popis produktu 2.',
        'price' => 200
    ],
    3 => [
        'name' => 'Produkt 3',
        'image' => 'product3.jpg',
        'description' => 'Popis produktu 3.',
        'price' => 300
    ]
];

// Získání ID produktu z URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kontrola, zda produkt existuje
if (!isset($products[$id])) {
    echo "<h1>Produkt nenalezen</h1>";
    exit;
}

// Získání dat produktu
$product = $products[$id];
?>

<h1><?php echo htmlspecialchars($product['name']); ?></h1>

<img src="<?php echo htmlspecialchars($product['image']); ?>" width="300">

<p><?php echo htmlspecialchars($product['description']); ?></p>

<p><?php echo htmlspecialchars($product['price']); ?> Kč</p>

<a href="cart.php?id=<?php echo $id; ?>">Přidat do košíku</a>

<a href="wishlist.php?id=<?php echo $id; ?>">Oblíbené</a>