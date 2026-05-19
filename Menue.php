<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['Registrieren'])) {
            header("Location: Registrieren.php");
        } elseif (isset($_POST['Login'])) {
            header("Location: Login.php");
        } elseif (isset($_POST['Angebote'])) {
            header("Location: Angebote.php");
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
    <link rel="stylesheet" href="style_menue.css">
</head>
<nav>
    <form action="" method="post">
        <input type="submit" value="Abmelden" id="abmelden" name="abmelden">
    </form>
        <?php
        
            if(isset($_POST["abmelden"])){
                session_destroy();
                header("location:Menue.php");
            }
        ?>
        <br>
</nav>
<body>
    <h1>Hauptmenü</h1>
    <br>
    <?php
    if (isset($_SESSION['vorname']) && isset($_SESSION['nachname'])) {
        echo "<p>Willkommen, " . $_SESSION['vorname'] . " " . $_SESSION['nachname'] . "!</p>";
    } else {
        echo "<p>Willkommen, Gast!</p>";
    }
    ?>
    <form action="" method="post">
        <p><input type="submit" name="Registrieren" value="Registrieren"></p>
        <p><input type="submit" name="Login" value="Login"></p>
        <p><input type="submit" name="Angebote" value="Angebote"></p>
        <p><input type="submit" name="Reservierungen" value="Reservierungen"></p>
    </form>
</body>
</html>