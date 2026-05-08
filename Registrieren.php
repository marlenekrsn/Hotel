<?php
    session_start();
    $message = "";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
    
        $vorname = trim($_POST["vorname"]);
        $nachname = trim($_POST["nachname"]);
        $strasse = trim($_POST["strasse"]);
        $plz = $_POST["plz"];   
        $ort = trim($_POST["ort"]);
        $email = trim($_POST["email"]);
        $passwort = trim($_POST["passwort"]);
        $passwort2 = trim($_POST["passwort2"]);

        if (!empty($vorname) && !empty($nachname) && !empty($strasse) && !empty($plz) && !empty($ort) && !empty($email) && !empty($passwort) && !empty($passwort2)) {
            if ($passwort === !$passwort2) {
                echo 'Passwörter stimmen nicht überein';
            } else {
                //1. Passwort hashen
                $passwordHash = password_hash($passwort, PASSWORD_DEFAULT);

                //2. In der DB speichern
                require_once('dbVerbindung.php');

                try {

                $sql = "INSERT INTO `benutzer`( `vorname`, `nachname`, `strasse`, `plz`, `ort`, `email`, `passwort`) VALUES ( :vorname, :nachname, :strasse, :plz, :ort, :email, :passwort)";
                $stmt = $pdo->prepare($sql);

                    if ($stmt->execute([':vorname' => $vorname, ':nachname' => $nachname, ':strasse' => $strasse, ':plz' => $plz, ':ort' => $ort, ':email' => $email, ':passwort' => $passwordHash,])) {
                        $message = "Registrierung erfolgreich <a href=\"Login.php\">Zum Login</a>";
                        header("Location: Login.php");

                    }

                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) { //Code für Dublicated Entry

                        echo"Email ist bereits im System";

                    } else {

                        $message = "Es ist ein Fehler beim Registrieren aufgetreten: " . $e->getMessage();

                    }

                }


            }
        }
    }


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
        <label for="vorname">Vorname</label> <input type="text" placeholder="Max" name="vorname" required><br>

        <label for="nachname">Nachname</label> <input type="text" placeholder="Mustermann" name="nachname" required><br>

        <label for="strasse">Straße</label> <input type="text" placeholder="Mustermannsstraße 1" name="strasse" required><br>

        <label for="plz">Postleitzahl</label> <input type="text" placeholder="1234" name="plz" required><br>

        <label for="ort">Ort</label> <input type="text" placeholder="Musterstadt" name="ort" required><br>

        <label for="email">Email</label> <input type="email" placeholder="maxmustermann@email.com" name="email" required><br>

        <label for="passwort">Passwort</label>
        <input type="password" name="passwort" placeholder="Passwort" required>
        <input type="password" name="passwort2" placeholder="Passwort wiederholen" required>

        <input type="submit" value="Registrieren" name="submit">

    </form>
</body>
</html>