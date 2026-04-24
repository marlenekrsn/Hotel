<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
</head>
<nav>
    <form action="" method="post">
        <input type="submit" value="Zurück" id="zurueck" name="zurueck">
    </form>
    <?php
        if(isset($_POST["zurueck"])){
            header("location:Menue.php");
        }
    ?>
</nav>
<body>
    <form action="" method="post">
        <label for="vorname">Vorname</label> <input type="text" placeholder="Max"><br>

        <label for="nachname">Nachname</label> <input type="text" placeholder="Mustermann"><br>

        <label for="adresse">Adresse</label> <input type="text" placeholder="Mustermannsstraße 1"><br>

        <label for="postleitzahl">Postleitzahl</label> <input type="text" placeholder="1234"><br>

        <label for="ort">Ort</label> <input type="text" placeholder="Musterstadt"><br>

        <label for="email">Email</label> <input type="email" placeholder="maxmustermann@email.com"><br>

        <label for="passwort">Passwort</label>
        <input type="password" name="passwort" placeholder="Passwort" required>
        <input type="password" name="passwort2" placeholder="Passwort wiederholen" required>

        <input type="submit" value="Registrieren" name="registrieren>

    </form>
</body>
</html>