<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['Registrieren'])) {
            header("Location: Registrieren.php");
        } elseif (isset($_POST['Login'])) {
            header("Location: Login.php");
        } elseif (isset($_POST['Angebote'])) {
            header("Location: Angebote.php");
        } elseif (isset($_POST['Warenkorb'])) {
            header("Location: Warenkorb.php");
        } elseif (isset($_POST['Reservierungen'])) {
            header("Location: Reservierungen.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptmenü</title>
</head>
<body>
    <h1>Hauptmenü</h1>
    <form action="" method="post">
        <p><input type="submit" name="Registrieren" value="Registrieren"></p>
        <p><input type="submit" name="Login" value="Login"></p>
        <p><input type="submit" name="Angebote" value="Angebote"></p>
        <p><input type="submit" name="Warenkorb" value="Warenkorb"></p>
        <p><input type="submit" name="Reservierungen" value="Reservierungen"></p>
    </form>
</body>
</html>