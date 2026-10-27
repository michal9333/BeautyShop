<?php
session_start();

$chyba = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'beautyshop');
    $conn->set_charset('utf8mb4');

    $email = trim($_POST['email'] ?? '');
    $heslo = $_POST['password'] ?? '';

    $stmt = $conn->prepare(
        "SELECT id, password FROM users WHERE email = ? LIMIT 1"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $vysledok = $stmt->get_result();
    $user = $vysledok->fetch_assoc();

    if ($user && password_verify($heslo, $user['password'])
        && $email === 'admin@beautyshop.local') {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $user['id'];
        header('Location: admin.php');
        exit;
    } else {
        $chyba = 'Nesprávny e-mail alebo heslo.';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Prihlásenie administrátora – BeautyShop</title>
</head>
<body>
<h1>Administrácia BeautyShop</h1>

<?php if ($chyba): ?>
<p><?= htmlspecialchars($chyba) ?></p>
<?php endif; ?>

<form method="post">
    <label>E-mail</label><br>
    <input type="email" name="email" required><br><br>

    <label>Heslo</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Prihlásiť sa</button>
</form>
</body>
</html>
