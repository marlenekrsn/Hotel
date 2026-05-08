<?php

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $passwort = $_POST['passwort'];

    
    require_once('dbVerbindung.php');
    $stmt = $pdo->prepare("SELECT bid, vorname, nachname, email, passwort FROM benutzer WHERE email = :email");

    
    $stmt->execute(['email' => $email]);
    
    $user = $stmt->fetch(); //Der gewünschte Datensatz des eingeloggten Users wird zurückgegeben

    //2. Passwort überprüfen
    if ($user && password_verify($passwort, $user['passwort'])) {
        //User darf sich einloggen

        //SICHERHEITS-UPDATE 
        //prüfen, ob der Hash veraltet ist (wenn ja, erneuern und in der DB speichern)
        if (password_needs_rehash($user['passwort'], PASSWORD_DEFAULT)) {

            //neuen Hash generien
            $newHash = password_hash($passwort, PASSWORD_DEFAULT);

            //neuen Hash in der DB speichern
            $updateStmt = $pdo->prepare("UPDATE users SET passwort = :passwort WHERE id = :id");
            $updateStmt->execute(['passwort' => $newHash, 'id' => $user['id']]);


        }
        //Session setzen (Schutz vor Session Fication)
        session_regenerate_id(true);


        //Die Session mit Daten befüllen
        $_SESSION['bid'] = $user['bid'];
        $_SESSION['vorname'] = $user['vorname'];
        $_SESSION['nachname'] = $user['nachname'];
        $_SESSION['strasse'] = $user['strasse'];
        $_SESSION['postleitzahl'] = $user['postleitzahl'];
        $_SESSION['ort'] = $user['ort'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['passwort'] = $user['passwort'];
        
        
        

        header('Location: menue.php');

    } else {
        echo"Benutzername oder Passwort falsch.";
        $messageType = "error";
    }

}

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
    <label for="passwort">Passwort</label> <input type="passwort" name="passwort" id="passwort"><br>
    <input type="submit" value="Anmelden">
</form>
</body>
</html>