<?php

include"config.php";

if($_POST) {
    $email=$_POST['email'];

    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");

    echo"Registrace byla úspěšná! Můžete se nyní přihlásit.";

}

?>

<FROM method="post">

    <input name="email" placeholder="E-mail" 

    <input name="password"type="password" placeholder="Heslo">

    <button>Registrovat se</button>

</FROM>