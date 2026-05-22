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
        $error_msg = "E-Mail oder Passwort falsch.";
        $messageType = "error";
    }

}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel Kamel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <header class="header-nav">
        <form action="" method="post" class="nav-form">
            <button type="submit" id="zurueck" name="zurueck" class="btn-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Zurück
            </button>
        </form>
        <?php
            if(isset($_POST["zurueck"])){
                header("location:Menue.php");
            }
        ?>
    </header>

    <div class="login-container">
        <div class="login-card">
            <div class="hotel-logo">
                <span class="logo-icon">🐫</span>
                <h2>Hotel Kamel</h2>
                <div class="logo-divider"></div>
            </div>
            
            <h3>Willkommen zurück</h3>
            <p class="subtitle">Melden Sie sich an, um Ihren Aufenthalt zu verwalten.</p>

            <?php if (isset($error_msg)): ?>
                <div class="error-box">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text"><?= htmlspecialchars($error_msg) ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="login-form">
                <div class="input-group">
                    <label for="email">E-Mail-Adresse</label>
                    <input type="email" name="email" id="email" placeholder="maxmustermann@email.com" required>
                </div>
                
                <div class="input-group">
                    <label for="passwort">Passwort</label>
                    <input type="password" name="passwort" id="passwort" placeholder="Passwort eingeben" required>
                </div>
                
                <button type="submit" class="btn-submit">Anmelden</button>
            </form>
            
            <div class="card-footer">
                <p>Noch kein Mitglied? <a href="Registrieren.php">Jetzt registrieren</a></p>
            </div>
        </div>
    </div>
</body>
</html>