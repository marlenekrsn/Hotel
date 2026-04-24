<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <h3>Bitte geben Sie folgende Informationen ein, um sich anzumelden</h3>
    <label for="email">Email</label> <input type="email" name="email" id="email" placeholder="maxmustermann@email.com"><br>
    <label for="passwort">Passwort</label> <input type="password" name="password" id="password"><br>
    <input type="submit" value="Anmelden">
</form>
</body>
</html>