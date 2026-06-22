<?php
    session_start();
    $message = "";

    if($_SERVER["REQUEST_METHOD"] === "POST"){
    
        $vorname= htmlspecialchars(trim($_POST["vorname"]));
        $nachname= htmlspecialchars(trim($_POST["nachname"]));
        $strasse= htmlspecialchars(trim($_POST["strasse"]));
        $plz= htmlspecialchars(trim($_POST["plz"]));
        $ort= htmlspecialchars(trim($_POST["ort"]));
        $email= htmlspecialchars(trim($_POST["email"]));
        $passwort= trim($_POST["passwort"]);
        $passwort2= trim($_POST["passwort2"]);

        if (!empty($vorname) && !empty($nachname) && !empty($strasse) && !empty($plz) && !empty($ort) && !empty($email) && !empty($passwort) && !empty($passwort2)) {
            if ($passwort !== $passwort2) {
                $error_msg = 'Passwörter stimmen nicht überein';
            } else {
                //1. Passwort hashen
                $passwordHash = password_hash($passwort, PASSWORD_DEFAULT);

                //2. In der DB speichern
                require_once('dbVerbindung.php');

                try {

                $sql = "INSERT INTO `benutzer`( `vorname`, `nachname`, `strasse`, `plz`, `ort`, `email`, `passwort`) VALUES ( :vorname, :nachname, :strasse, :plz, :ort, :email, :passwort)";
                $stmt = $pdo->prepare($sql);

                    if ($stmt->execute([':vorname' => $vorname, ':nachname' => $nachname, ':strasse' => $strasse, ':plz' => $plz, ':ort' => $ort, ':email' => $email, ':passwort' => $passwordHash,])) {
                        $success_msg = "Registrierung erfolgreich!";
                        header("Location: Login.php");
                        exit;
                    }

                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) { //Code für Duplicate Entry
                        $error_msg = "Diese E-Mail ist bereits im System registriert.";
                    } else {
                        $error_msg = "Es ist ein Fehler beim Registrieren aufgetreten: " . $e->getMessage();
                    }
                }
            }
        } else {
            $error_msg = "Bitte füllen Sie alle Felder aus.";
        }
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren - Hotel Kamel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_registrieren.css">
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

    <div class="registration-container">
        <div class="registration-card">
            <div class="hotel-logo">
                <span class="logo-icon">🐫</span>
                <h2>Hotel Kamel</h2>
                <div class="logo-divider"></div>
            </div>
            
            <h3>Mitglied werden</h3>
            <p class="subtitle">Registrieren Sie ein neues Konto, um Ihren Traumurlaub zu buchen.</p>

            <form action="" method="post" class="registration-form">
                <div class="form-grid">
                    <div class="input-group">
                        <label for="vorname">Vorname</label>
                        <input type="text" id="vorname" placeholder="Max" name="vorname" required>
                    </div>

                    <div class="input-group">
                        <label for="nachname">Nachname</label>
                        <input type="text" id="nachname" placeholder="Mustermann" name="nachname" required>
                    </div>

                    <div class="input-group full-width">
                        <label for="strasse">Straße & Hausnummer</label>
                        <input type="text" id="strasse" placeholder="Musterstraße 1" name="strasse" required>
                    </div>

                    <div class="input-group">
                        <label for="plz">Postleitzahl</label>
                        <input type="text" id="plz" placeholder="1234" name="plz" required>
                    </div>

                    <div class="input-group">
                        <label for="ort">Ort</label>
                        <input type="text" id="ort" placeholder="Musterstadt" name="ort" required>
                    </div>

                    <div class="input-group full-width">
                        <label for="email">E-Mail-Adresse</label>
                        <input type="email" id="email" placeholder="maxmustermann@email.com" name="email" required>
                    </div>

                    <div class="input-group">
                        <label for="passwort">Passwort</label>
                        <input type="password" id="passwort" name="passwort" placeholder="Passwort" required>
                    </div>

                    <div class="input-group">
                        <label for="passwort2">Wiederholen</label>
                        <input type="password" id="passwort2" name="passwort2" placeholder="Passwort" required>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-submit">Registrieren</button>
            </form>
            
            <div class="card-footer">
                <p>Bereits registriert? <a href="Login.php">Hier anmelden</a></p>
            </div>
        </div>
    </div>
</body>
</html>